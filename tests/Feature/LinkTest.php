<?php

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_their_own_link()
    {
        // Arrange
        $user = User::factory()->create();
        $link = Link::factory()->for($user)->create([
            'user_id' => $user->id,
            'title' => 'Test Link',
            'description' => 'description',
            'site_id' => '1',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ]);

        // Act
        $response = $this->actingAs($user)->get("/links/{$link->id}");

        // Assert
        $response->assertOk();
        $response->assertViewIs('links.show');
        $response->assertViewHas('link', $link);
        $response->assertSee('Test Link');
    }

    public function test_user_can_see_only_their_links_on_index_page()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $linkA = Link::factory()->for($userA)->create([
            'user_id' => $userA->id,
            'title' => 'Link A',
            'description' => 'description',
            'site_id' => '1',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ]);
        $LinkB = Link::factory()->for($userB)->create([
            'user_id' => $userB->id,
            'title' => 'Link B',
            'description' => 'description',
            'site_id' => '1',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ]);

        // Act
        $response = $this->actingAs($userA)->get('/links');

        // Assert
        $response->assertOk();
        $response->assertViewIs('links.index');
        $response->assertSee('Link A');
        $response->assertDontSee('Link B');
    }

    public function test_user_can_create_link()
    {
        // Arrange
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'title' => 'ValidTitle',
            'description' => 'description',
            'site' => 'Linkedin',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ];

        // Act
        $response = $this->actingAs($user)->post('/links', $data);

        // Assert
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('link.store', 'Link Created Successfully');
        $response->assertRedirect('/links');
        $this->assertDatabaseHas('links', [
            'user_id' => $user->id,
            'title' => 'ValidTitle',
            'description' => 'description',
            'site_id' => '1',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ]);
    }

    public function test_user_cannot_create_link_with_empty_fields()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->from('/links/create')->post('/links', []);

        // Assert
        $response->assertSessionHasErrors(['title', 'description', 'site', 'url']);
        $response->assertRedirect('/links/create');
    }

    public function test_user_cannot_create_links_with_nonexistence_site()
    {
        // Arrange
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'title' => 'ValidTitle',
            'description' => 'description',
            'site' => 'InvaildSite',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ];

        // Act
        $response = $this->actingAs($user)->from('/links/create')->post('/links', $data);

        // Assert
        $response->assertSessionHasErrors('site');
        $response->assertRedirect('/links/create');
    }

    public function test_user_cannot_see_another_user_link()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $data = [
            'user_id' => $userB->id,
            'title' => 'ValidTitle',
            'description' => 'description',
            'site_id' => '1',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ];

        $link = Link::factory()->for($userB)->create($data);

        $this->actingAs($userA);

        // Act
        $response = $this->from('/links')->get("/links/{$link->id}");

        // Assert
        $response->assertNotFound();
    }

    public function test_user_can_edit_his_link()
    {
        // Arrange
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'title' => 'ValidTitle',
            'description' => 'description',
            'site_id' => '1',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ];
        $newData = [
            'user_id' => $user->id,
            'title' => 'ValidTitle',
            'description' => 'NewDescription',
            'site' => 'Reddit',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ];

        $link = Link::factory()->for($user)->create($data);

        // Act
        $response = $this->actingAs($user)->from("/links/{$link->id}/edit/")->put("/links/{$link->id}", $newData);

        // Assert
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/links');

        $this->assertDatabaseCount('links', 1);
        $this->assertDatabaseHas('links', [
            'user_id' => $user->id,
            'title' => 'ValidTitle',
            'description' => 'NewDescription',
            'site_id' => '2',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ]);
    }

    public function test_user_cannot_edit_another_user_link()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $data = [
            'user_id' => $userB->id,
            'title' => 'ValidTitle',
            'description' => 'description',
            'site_id' => '1',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ];
        $newData = [
            'user_id' => $userB->id,
            'title' => 'ValidTitle',
            'description' => 'NewDescription',
            'site' => 'Reddit',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ];

        $link = Link::factory()->for($userB)->create($data);

        // Act
        $response = $this->actingAs($userA)->from("/links/{$link->id}/edit/")->put("/links/{$link->id}", $newData);

        // Assert
        $response->assertNotFound();

        $this->assertDatabaseCount('links', 1);
        $this->assertDatabaseMissing('links', [
            'user_id' => $userB->id,
            'title' => 'ValidTitle',
            'description' => 'NewDescription',
            'site_id' => '2',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ]);
    }

    public function test_user_can_delete_his_link()
    {
        // Arrange
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'title' => 'ValidTitle',
            'description' => 'description',
            'site_id' => '1',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ];

        $link = Link::factory()->for($user)->create($data);

        // Act
        $response = $this->actingAs($user)->from('/links')->delete("/links/{$link->id}");

        // Assert
        $response->assertRedirect('/links');
        $this->assertDatabaseCount('links', 0);
    }

    public function test_user_cannot_delete_another_user_link()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $data = [
            'user_id' => $userB->id,
            'title' => 'ValidTitle',
            'description' => 'description',
            'site_id' => '1',
            'status' => 0,
            'url' => 'https://www.linkedin.com',
        ];

        $link = Link::factory()->for($userB)->create($data);

        // Act
        $response = $this->actingAs($userA)->from('/links')->delete("/links/{$link->id}");

        // Assert
        $response->assertNotFound();

        $this->assertDatabaseCount('links', 1);
    }
}
