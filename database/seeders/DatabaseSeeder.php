<?php

namespace Database\Seeders;

use App\Models\Atleta;
use App\Models\Evento;
use App\Models\Inscricoes;
use App\Models\Modalidade;
use App\Models\Time;
use Illuminate\Database\Seeder;

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