<?php

namespace Tests\Feature;

use App\Models\Medico;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MedicoManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_medico_index(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('medicos.index'));

        $response->assertOk();
    }

    public function test_non_admin_cannot_access_medico_routes(): void
    {
        $user = User::factory()->create(['role' => 'paciente']);

        $this->actingAs($user)
            ->get(route('medicos.index'))
            ->assertStatus(403);
    }

    public function test_admin_can_create_medico(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $credentials = [
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'especialidad' => 'Cardiología',
            'email' => 'juan.perez@example.com',
            'password' => 'secret123',
        ];

        $response = $this->actingAs($admin)->post(route('medicos.store'), $credentials);

        $response->assertRedirect(route('medicos.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('medicos', [
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'especialidad' => 'Cardiología',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'juan.perez@example.com',
            'role' => 'doctor',
        ]);

        // La contraseña debe estar cifrada, no almacenada en texto plano
        $user = User::where('email', 'juan.perez@example.com')->first();
        $this->assertTrue(
            Hash::check('secret123', $user->password),
            'Password was not hashed correctly'
        );

        $this->assertEquals(
            Medico::where('nombre', 'Juan')->first()->id,
            $user->medico_id
        );
    }
}
