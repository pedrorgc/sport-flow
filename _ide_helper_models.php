<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $nome
 * @property string|null $cpf_rg
 * @property string $data_nascimento
 * @property int $modalidade_id
 * @property string $categoria
 * @property string|null $contato
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Modalidade $modalidade
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Time> $times
 * @property-read int|null $times_count
 * @method static \Database\Factories\AtletaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta whereCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta whereContato($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta whereCpfRg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta whereDataNascimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta whereModalidadeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Atleta whereUpdatedAt($value)
 */
	class Atleta extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nome
 * @property int $modalidade_id
 * @property string $data_inicio
 * @property string $data_fim
 * @property string $prazo_inscricoes
 * @property string $local
 * @property string|null $descricao
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Inscricoes> $inscricoes
 * @property-read int|null $inscricoes_count
 * @property-read \App\Models\Modalidade $modalidade
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Resultado> $resultados
 * @property-read int|null $resultados_count
 * @method static \Database\Factories\EventoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereDataFim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereDataInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereModalidadeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento wherePrazoInscricoes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evento whereUpdatedAt($value)
 */
	class Evento extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $evento_id
 * @property int|null $atleta_id
 * @property int|null $time_id
 * @property string $status_inscricao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Atleta|null $atleta
 * @property-read \App\Models\Evento $evento
 * @property-read \App\Models\Time|null $time
 * @method static \Database\Factories\InscricoesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inscricoes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inscricoes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inscricoes query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inscricoes whereAtletaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inscricoes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inscricoes whereEventoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inscricoes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inscricoes whereStatusInscricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inscricoes whereTimeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inscricoes whereUpdatedAt($value)
 */
	class Inscricoes extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $nome
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modalidade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modalidade newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modalidade query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modalidade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modalidade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modalidade whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modalidade whereUpdatedAt($value)
 */
	class Modalidade extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $evento_id
 * @property int $inscricao_id
 * @property int $posicao
 * @property string|null $marca_pontuacao
 * @property-read \App\Models\Evento $evento
 * @property-read \App\Models\Inscricoes $inscricao
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resultado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resultado newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resultado query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resultado whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resultado whereEventoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resultado whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resultado whereInscricaoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resultado whereMarcaPontuacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resultado wherePosicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resultado whereUpdatedAt($value)
 */
	class Resultado extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nome
 * @property int $modalidade_id
 * @property string $categoria
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Atleta> $atletas
 * @property-read int|null $atletas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Inscricoes> $inscricoes
 * @property-read int|null $inscricoes_count
 * @property-read \App\Models\Modalidade $modalidade
 * @method static \Database\Factories\TimeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Time newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Time newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Time query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Time whereCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Time whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Time whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Time whereModalidadeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Time whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Time whereUpdatedAt($value)
 */
	class Time extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

