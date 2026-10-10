<?php

use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * NOTE: there is an observer that create 3 default site for each new user,
     * and the default value for column 'name' in site DB is 'Youtube',
     * so in some cases in testing there is 4 default value for each user.
     */

    public function test_user_can_view_their_own_sites()
    {
        // Arrange
        $user = User::factory()->create();
        Site::factory()->for($user)->create([
            'name' => 'GeeksForGeeks',
        ]);

        // Act
        $response = $this->actingAs($user)->get("/sites");

        // Assert
        $response->assertOk();
        $response->assertViewIs('sites.index');
        $response->assertSee('GeeksForGeeks');
    }

    public function test_user_cannot_view_another_user_sites()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $siteA = Site::factory()->for($userA)->create([
            'name' => 'Site A',
        ]);
        $siteB = Site::factory()->for($userB)->create([
            'name' => 'Site B',
        ]);

        // Act
        $response = $this->actingAs($userA)->get('/sites');

        // Assert
        $response->assertViewIs('sites.index');
        $response->assertSee('Site A');
        $response->assertDontSee('Site B');
    }

    public function test_user_can_create_a_site()
    {
        // Arrange
        $user = User::withoutEvents(function (){
            return User::factory()->create();
        }) ;
        $data = [
            'name' => 'GeeksForGeeks'
        ];

        // Act
        $response = $this->actingAs($user)->from('/sites')->post('/sites',$data);

        // Assert
        $response->assertRedirect('/sites');
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('site.store', 'Site Created Successfully');

        $this->assertDatabaseCount('sites', 1);
        $this->assertDatabaseHas('sites',[
            'user_id' => $user->id,
            ...$data,
        ]);
    }

    public function test_user_cannot_create_with_empty_name_field()
    {
        // Arrange
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $data = [
            'name' => '',
        ];

        // Act
        $response = $this->actingAs($user)->from("/sites")->post("/sites", $data);

        // Assert
        $response->assertRedirect("/sites");
        $response->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('sites', 0);
        $this->assertDatabaseMissing('sites', [
            'user_id' => $user->id,
            'name' => '',
        ]);
    }

    public function test_user_can_edit_his_site()
    {
        // Arrange
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $site = Site::factory()->for($user)->create(['name' => 'GeekForGeek']);
        $data = [
            'name' => 'GeeksForGeeks',
        ];

        // Act
        $response = $this->actingAs($user)->from("/sites/{$site->id}/edit")->put("/sites/{$site->id}", $data);

        // Assert
        $response->assertRedirect('/sites');
        $response->assertSessionHas('site.update', 'Site Updated Successfully');

        $this->assertDatabaseCount('sites', 1);
        $this->assertDatabaseHas('sites', [
            'user_id' => $user->id,
            ...$data,
        ]);
    }

    public function test_user_cannot_edit_with_empty_name_field()
    {
        // Arrange
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $site = Site::factory()->for($user)->create(['name' => 'LinkIn']);
        $data = [
            'name' => '',
        ];

        // Act
        $response = $this->actingAs($user)->from("/sites/{$site->id}/edit")->put("/sites/{$site->id}", $data);

        // Assert
        $response->assertRedirect("/sites/{$site->id}/edit");
        $response->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('sites', 1);
        $this->assertDatabaseHas('sites', [
            'user_id' => $user->id,
            'name' => 'LinkIn',
        ]);
        $this->assertDatabaseMissing('sites', [
            'user_id' => $user->id,
            'name' => '',
        ]);
    }

    public function test_user_cannot_edit_another_user_site()
    {
        // Arrange
        $userA = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $userB = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $siteA = Site::factory()->for($userA)->create([
            'name' => 'Site A',
        ]);
        $siteB = Site::factory()->for($userB)->create([
            'name' => 'Site B',
        ]);

        $data = [
            'name' => 'Edit Data',
        ];

        // Act
        $response = $this->actingAs($userA)->from("/sites/{$siteA->id}/edit")->put("/sites/{$siteB->id}", $data);

        // Assert
        $response->assertNotFound();

        $this->assertDatabaseCount('sites', 2);
        $this->assertDatabaseMissing('sites', [
            'user_id' => $userB->id,
            ...$data,
        ]);
    }

    public function test_user_can_delete_his_site()
    {
        // Arrange
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $data = [
            'name' => 'GeeksForGeeks',
        ];
        $site = Site::factory()->for($user)->create($data);

        // Act
        $response = $this->actingAs($user)->from("/sites")->delete("/sites/{$site->id}");

        // Assert
        $response->assertRedirect('/sites');
        $response->assertSessionHas('site.destroy', 'Site deleted Successfully');

        $this->assertDatabaseCount('sites', 0);
        $this->assertDatabaseMissing('sites', [
            'user_id' => $user->id,
            ...$data,
        ]);
    }

    public function test_user_cannot_delete_another_user_site()
    {
        // Arrange
        $userA = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $userB = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $data = [
            'name' => 'GeeksForGeeks',
        ];

        $site = Site::factory()->for($userB)->create($data);

        // Act
        $response = $this->actingAs($userA)->from('/sites')->delete("/sites/{$site->id}");

        // Assert
        $response->assertNotFound();

        $this->assertDatabaseCount('sites', 1);
        $this->assertDatabaseHas('sites',[
            'user_id' => $userB->id,
            ...$data,
        ]);
    }

}
