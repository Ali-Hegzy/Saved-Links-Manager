<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SessionTest extends TestCase
{
    use RefreshDatabase;

    private $name = 'Samir Khaled';

    private $email = 'testmail@email.com';

    private $password = '83871a6e923aa277ee118eaa1c91f4476a21cdf2Testemail@mail.com';

    public function test_user_can_login_with_valid_data()
    {
        // Arrange
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];

        User::factory()->create($data);

        // Act
        $response = $this->from('/login')->post('/login', $data);

        // Assert
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/');
        $response->assertSessionHas('loggedIn', 'Logged In Successfully.');

        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_incorrect_credentials()
    {
        // Arrange
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];

        User::factory()->create($data);

        // Act
        $response = $this->from('/login')->post('/login', [
            'email' => 'wrong-email@example.com'.'salt',
            'password' => '123',
        ]);

        // Assert
        $response->assertSessionHasErrors(['password']);
        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_user_cannot_login_with_empty_fields()
    {
        // Arrange
        $data = [];

        // Act
        $response = $this->from('/login')->post('/login', $data);

        // Assert
        $response->assertSessionHasErrors(['email', 'password']);
        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_auth_user_can_logout()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->delete('/logout');

        // Assert
        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_protected_page()
    {
        // Arrange

        // Act
        $response = $this->from('/')->get('/profile');

        // Assert
        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_auth_cannot_access_guest_only_page()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $this->actingAs($user);
        $response = $this->from('/links')->get('/login');

        // Assert
        $this->assertAuthenticated();
        $response->assertRedirect('/links');
    }
}
