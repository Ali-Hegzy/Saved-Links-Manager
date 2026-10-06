<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data()
    {
        // Arrange
        $data = [
            'name' => 'Alan Doe',
            'email' => 'testemail@mail.com',
            'password' => '83871a6e923aa277ee118eaa1c91f4476a21cdf2Testemail@mail.com',
        ];

        // Act
        $response = $this->from('/register')->post('/register', $data);

        // Assert
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/');
        $response->assertSessionHas('registered', 'The account has been registered successfully.');

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'name' => 'Alan Doe',
            'email' => 'testemail@mail.com',
        ]);
    }

    public function test_user_cannot_register_with_empty_fields()
    {
        // Arrange
        $data = [];

        // Act
        $response = $this->from('/register')->post('/register', $data);

        // Assert
        $response->assertSessionHasErrors(['email', 'name', 'password']);
        $response->assertRedirect('/register');

        $this->assertGuest();

        $this->assertDatabaseCount('users', 0);
    }

    public function test_user_cannot_register_with_existing_email()
    {
        // Arrange
        User::factory()->create([
            'email' => 'testemail@mail.com',
        ]);

        $data = [
            'name' => 'Alan Doe',
            'email' => 'testemail@mail.com',
            'password' => '83871a6e923aa277ee118eaa1c91f4476a21cdf2Testemail@mail.com',
        ];

        // Act
        $response = $this->from('/register')->post('/register', $data);

        // Assert
        $response->assertSessionHasErrors(['email']);
        $response->assertRedirect('/register');

        $this->assertGuest();

        $this->assertDatabaseMissing('users', [
            'name' => 'Alan Doe',
        ]);

        $this->assertDatabaseCount('users', 1);
    }
}
