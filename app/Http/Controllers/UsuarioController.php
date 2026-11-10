<?php

namespace App\Http\Controllers;

use App\Enums\Papel;
use App\Http\Requests\UsuarioRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $usuarios = User::query()
            ->when($request->filled('busca'), function ($q) use ($request) {
                $termo = '%' . $request->input('busca') . '%';
                $q->where(fn ($q) => $q->where('name', 'like', $termo)->orWhere('username', 'like', $termo));
            })
            ->when(Papel::tryFrom((string) $request->input('papel')), fn ($q, $papel) => $q->where('role', $papel))
            ->when($request->input('status') === 'ativos', fn ($q) => $q->where('ativo', true))
            ->when($request->input('status') === 'bloqueados', fn ($q) => $q->where('ativo', false))
            ->orderByDesc('ativo')
            ->orderBy('name')
            ->get();

        $totais = [
            'total' => User::count(),
            'gestores' => User::where('role', Papel::Gestor)->count(),
            'monitores' => User::where('role', Papel::Monitor)->count(),
            'bloqueados' => User::where('ativo', false)->count(),
        ];

        return view('usuarios.index', [
            'usuarios' => $usuarios,
            'totais' => $totais,
            'papeis' => Papel::cases(),
        ]);
    }

    public function store(UsuarioRequest $request): RedirectResponse
    {
        $senha = $this->gerarSenhaTemporaria();

        $usuario = User::forceCreate([
            'name' => $request->validated('name'),
            'username' => $request->validated('username'),
            'role' => $request->validated('role'),
            'password' => $senha,
            'ativo' => true,
            'must_change_password' => true,
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', "Usuário {$usuario->username} cadastrado.")
            ->with('senha_temporaria', ['usuario' => $usuario->username, 'senha' => $senha]);
    }

    public function update(UsuarioRequest $request, User $usuario): RedirectResponse
    {
        $novoPapel = Papel::from($request->validated('role'));

        if ($usuario->is($request->user()) && $novoPapel !== $usuario->role) {
            return back()->withErrors(['role' => 'Você não pode alterar o seu próprio papel.']);
        }

        $usuario->forceFill([
            'name' => $request->validated('name'),
            'username' => $request->validated('username'),
            'role' => $novoPapel,
        ])->save();

        return redirect()->route('usuarios.index')->with('success', "Usuário {$usuario->username} atualizado.");
    }

    public function alternarAcesso(Request $request, User $usuario): RedirectResponse
    {
        if ($usuario->is($request->user())) {
            return back()->withErrors(['ativo' => 'Você não pode bloquear o seu próprio acesso.']);
        }

        // Quem é bloqueado com a sessão aberta é desconectado na próxima requisição (middleware 'ativo').
        $usuario->forceFill(['ativo' => ! $usuario->ativo])->save();

        $mensagem = $usuario->ativo ? 'liberado' : 'bloqueado';

        return redirect()->route('usuarios.index')->with('success', "Acesso de {$usuario->username} {$mensagem}.");
    }

    public function redefinirSenha(Request $request, User $usuario): RedirectResponse
    {
        if ($usuario->is($request->user())) {
            return back()->withErrors(['senha' => 'Para trocar a sua própria senha, use a tela Meu Perfil.']);
        }

        $senha = $this->gerarSenhaTemporaria();

        $usuario->forceFill(['password' => $senha, 'must_change_password' => true])->save();

        return redirect()->route('usuarios.index')
            ->with('success', "Senha de {$usuario->username} redefinida.")
            ->with('senha_temporaria', ['usuario' => $usuario->username, 'senha' => $senha]);
    }

    /** Só letras e números, para ser fácil de ditar ou digitar. */
    private function gerarSenhaTemporaria(): string
    {
        return Str::password(10, letters: true, numbers: true, symbols: false);
    }
}
