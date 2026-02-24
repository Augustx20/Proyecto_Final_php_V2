<?php

namespace Tests\Feature;

use App\Models\Medico;
use App\Models\Turno;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TurnoFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_create_turno_with_medico(): void
    {
        $user = User::factory()->create(['role' => 'paciente']);
        $medico = Medico::factory()->create();

        $response = $this->actingAs($user)->post(route('turnos.store'), [
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '10:00',
            'descripcion' => 'Consulta general',
            'medico_id' => $medico->id,
        ]);

        $response->assertRedirect(route('turnos.index'));
        $this->assertDatabaseHas('turnos', [
            'user_id' => $user->id,
            'medico_id' => $medico->id,
            'descripcion' => 'Consulta general',
        ]);
    }

    public function test_medico_id_is_required_when_creating_turno(): void
    {
        $user = User::factory()->create(['role' => 'paciente']);

        $response = $this->actingAs($user)->post(route('turnos.store'), [
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '10:00',
            'descripcion' => 'Consulta general',
        ]);

        $response->assertSessionHasErrors('medico_id');
    }

    public function test_patient_can_update_turno_medico(): void
    {
        $user = User::factory()->create(['role' => 'paciente']);
        $medico1 = Medico::factory()->create();
        $medico2 = Medico::factory()->create();

        $turno = Turno::create([
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '09:00',
            'descripcion' => 'Primera consulta',
            'medico_id' => $medico1->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->put(route('turnos.update', $turno), [
            'fecha' => $turno->fecha,
            'hora' => $turno->hora,
            'descripcion' => $turno->descripcion,
            'medico_id' => $medico2->id,
        ]);

        $response->assertRedirect(route('turnos.index'));
        $this->assertDatabaseHas('turnos', [
            'id' => $turno->id,
            'medico_id' => $medico2->id,
        ]);
    }
}
