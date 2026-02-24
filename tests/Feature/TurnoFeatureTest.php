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

    public function test_hora_must_be_on_the_dot_or_half(): void
    {
        $user = User::factory()->create(['role' => 'paciente']);
        $medico = Medico::factory()->create();

        $response = $this->actingAs($user)->post(route('turnos.store'), [
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '10:15',
            'descripcion' => 'Invalid minute',
            'medico_id' => $medico->id,
        ]);

        $response->assertSessionHasErrors('hora');
    }

    public function test_hora_must_be_within_working_hours(): void
    {
        $user = User::factory()->create(['role' => 'paciente']);
        $medico = Medico::factory()->create();

        $response = $this->actingAs($user)->post(route('turnos.store'), [
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '19:00',
            'descripcion' => 'Fuera de horario',
            'medico_id' => $medico->id,
        ]);

        $response->assertSessionHasErrors('hora');
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

    public function test_doctor_sees_only_his_turnos(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);
        $medico = Medico::factory()->create();
        $doctor->medico()->associate($medico)->save();

        $myTurno = Turno::create([
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '08:00',
            'descripcion' => 'Para mi',
            'medico_id' => $doctor->medico_id,
            'user_id' => User::factory()->create(['role' => 'paciente'])->id,
        ]);

        $otherTurno = Turno::create([
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '09:00',
            'descripcion' => 'Otro doctor',
            'medico_id' => Medico::factory()->create()->id,
            'user_id' => User::factory()->create(['role' => 'paciente'])->id,
        ]);

        $response = $this->actingAs($doctor)->get(route('turnos.index'));
        $response->assertSee('Para mi');
        $response->assertDontSee('Otro doctor');
    }

    public function test_doctor_can_finalize_and_derivar_turno(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);
        $medico = Medico::factory()->create();
        $doctor->medico()->associate($medico)->save();

        $paciente = User::factory()->create(['role' => 'paciente']);
        $turno = Turno::create([
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '10:00',
            'descripcion' => 'Consulta',
            'medico_id' => $medico->id,
            'user_id' => $paciente->id,
            'estado' => 'pendiente',
        ]);

        $this->actingAs($doctor)->post(route('turnos.finalizar', $turno));
        $this->assertDatabaseHas('turnos', ['id' => $turno->id, 'estado' => 'finalizado']);

        $newMedico = Medico::factory()->create();
        $this->actingAs($doctor)->post(route('turnos.derivar', $turno), [
            'nuevo_medico_id' => $newMedico->id,
        ]);
        $this->assertDatabaseHas('turnos', ['id' => $turno->id, 'medico_id' => $newMedico->id]);
    }

    public function test_doctor_toggle_availability(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);
        $medico = Medico::factory()->create(['disponible' => true]);
        $doctor->medico()->associate($medico)->save();

        $this->actingAs($doctor)->post(route('doctor.toggle'));
        $this->assertDatabaseHas('medicos', ['id' => $medico->id, 'disponible' => false]);
    }
}
