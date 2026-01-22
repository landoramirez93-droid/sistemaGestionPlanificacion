<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_crea_usuario(): void
    {
        $user = User::factory()->create([
            'name' => 'Orlando',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Orlando',
        ]);
    }
}