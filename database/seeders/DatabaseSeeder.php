<?php

namespace Database\Seeders;

use App\Models\Atleta;
use App\Models\Evento;
use App\Models\Inscricoes;
use App\Models\Modalidade;
use App\Models\Time;
use Illuminate\Database\Seeder;
use App\Models\Espaco;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        // Modalidades fixas
        Modalidade::create(['nome' => 'Futsal']);
        Modalidade::create(['nome' => 'Futebol']);
        Modalidade::create(['nome' => 'Basquete']);
        Modalidade::create(['nome' => 'Vôlei']);
        Modalidade::create(['nome' => 'Handebol']);

        // Locais fixos
        Espaco::create([
            'nome' => 'Centro Esportivo Municipal',
            'tipo' => 'Poliesportivo/Clube',
            'endereco' => 'Rua das Flores, 123, Centro',
            'capacidade' => 500,
        ]);
        Espaco::create([
            'nome' => 'Poliesportivo Do Ipê',
            'tipo' => 'Poliesportivo',
            'endereco' => 'Rua do Ipê, 456, Ipê',
            'capacidade' => 300,
        ]);
        Espaco::create([
            'nome' => 'Praça de Esportes do Cambalacho',
            'tipo' => 'Quadra Aberta',
            'endereco' => 'Rua do Cambalacho, 789, Centro',
            'capacidade' => 200,
        ]);
        Espaco::create([
            'nome' => 'Praça de Esportes do Curumim',
            'tipo' => 'Quadra Coberta',
            'endereco' => 'Rua do Curumim, 321, Vila Newtão',
            'capacidade' => 100,
        ]);
        
        // Atletas
        $atletas = Atleta::factory()->count(50)->create();

        // Times
        $times = Time::factory()->count(5)->create();

        // Relacionamento atleta/time
        foreach ($times as $time) {

            $atletasAleatorios = $atletas->random(rand(5, 10));

            $time->atletas()->attach(
                $atletasAleatorios->pluck('id')
            );
        }

        // Eventos
        $eventos = Evento::factory()->count(5)->create();

        // Inscrições
        foreach ($eventos as $evento) {

            $timesAleatorios = $times
                ->shuffle()
                ->take(rand(2, 5));

            foreach ($timesAleatorios as $time) {

                Inscricoes::factory()->create([
                    'evento_id' => $evento->id,
                    'time_id' => $time->id,
                ]);
            }
        }
    }
}