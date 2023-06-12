<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Hash;


class AuthTest extends TestCase
{
    /**
     * Testa login
     */
    public function testLogin()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'teste1234')
        ]);
        $loginData = [
            'email' => $user->getAttribute('email'),
            'password' => $password,
        ];
        $response = $this->postJson('/api/login', $loginData);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
