<?php

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_their_own_inventories()
    {
        // Arrange
        $user = User::factory()->create();
        Inventory::factory()->for($user)->create([
            'name' => 'Technical',
        ]);

        // Act
        $response = $this->actingAs($user)->get('/inventories');

        // Assert
        $response->assertOk();
        $response->assertViewIs('Inventory.index');
        $response->assertSee('Technical');
    }

    public function test_user_cannot_view_another_user_inventories()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $inventoryA = Inventory::factory()->for($userA)->create([
            'name' => 'Inventory A',
        ]);
        $inventoryB = Inventory::factory()->for($userB)->create([
            'name' => 'Inventory B',
        ]);

        // Act
        $response = $this->actingAs($userA)->get('/inventories');

        // Assert
        $response->assertViewIs('Inventory.index');
        $response->assertSee('Inventory A');
        $response->assertDontSee('Inventory B');
    }

    public function test_user_can_create_an_inventory()
    {
        // Arrange
        $user = User::factory()->create();
        $data = [
            'name' => 'Technical',
            'description' => 'For technical links',
        ];

        // Act
        $response = $this->actingAs($user)->from('/inventories')->post('/inventories', $data);

        // Assert
        $response->assertRedirect('/inventories');
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('inventory.store', 'Inventory Created Successfully');

        $this->assertDatabaseCount('inventories', 1);
        $this->assertDatabaseHas('inventories', [
            'user_id' => $user->id,
            ...$data,
        ]);
    }

    public function test_user_cannot_create_with_empty_fields()
    {
        // Arrange
        $user = User::factory()->create();
        $data = [
            'name' => '',
            'description' => '',
        ];

        // Act
        $response = $this->actingAs($user)->from('/inventories')->post('/inventories', $data);

        // Assert
        $response->assertRedirect('/inventories');
        $response->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('inventories', 0);
        $this->assertDatabaseMissing('inventories', [
            'user_id' => $user->id,
            'name' => '',
        ]);
    }

    public function test_user_can_edit_his_inventory()
    {
        // Arrange
        $user = User::factory()->create();
        $inventory = Inventory::factory()->for($user)->create([
            'name' => 'Tevh',
            'description' => 'For Technical links.',
        ]);
        $data = [
            'name' => 'Tech',
            'description' => 'For Technical links.', // Fix this to can test editing without send the non-change field
        ];

        // Act
        $response = $this->actingAs($user)->from("/inventories/{$inventory->id}/edit")->put("/inventories/{$inventory->id}", $data);

        // Assert
        $response->assertRedirect('/inventories');
        $response->assertSessionHas('inventory.update', 'Inventory Updated Successfully');

        $this->assertDatabaseCount('inventories', 1);
        $this->assertDatabaseHas('inventories', [
            'user_id' => $user->id,
            ...$data,
        ]);
    }

    public function test_user_cannot_edit_with_empty_name_fields()
    {
        // Arrange
        $user = User::factory()->create();
        $inventory = Inventory::factory()->for($user)->create([
            'name' => 'Tech',
            'description' => 'For Technical links.',
        ]);
        $data = [
            'name' => '',
            'description' => '',
        ];

        // Act
        $response = $this->actingAs($user)->from("/inventories/{$inventory->id}/edit")->put("/inventories/{$inventory->id}", $data);

        // Assert
        $response->assertRedirect("/inventories/{$inventory->id}/edit");
        $response->assertSessionHasErrors(['name', 'description']);

        $this->assertDatabaseCount('inventories', 1);
        $this->assertDatabaseHas('inventories', [
            'user_id' => $user->id,
            'name' => 'Tech',
        ]);
        $this->assertDatabaseMissing('inventories', [
            'user_id' => $user->id,
            'name' => '',
        ]);
    }

    public function test_user_cannot_edit_another_user_inventory()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $inventoryA = Inventory::factory()->for($userA)->create([
            'name' => 'inventory A',
            'description' => 'A',
        ]);
        $inventoryB = Inventory::factory()->for($userB)->create([
            'name' => 'inventory B',
            'description' => 'B',
        ]);

        $data = [
            'name' => 'Edit Data',
            'description' => 'Edit Data',
        ];

        // Act
        $response = $this->actingAs($userA)->from("/inventories/{$inventoryA->id}/edit")->put("/inventories/{$inventoryB->id}", $data);

        // Assert
        $response->assertNotFound();

        $this->assertDatabaseCount('inventories', 2);
        $this->assertDatabaseMissing('inventories', [
            'user_id' => $userB->id,
            ...$data,
        ]);
    }

    public function test_user_can_delete_his_inventory()
    {
        // Arrange
        $user = User::factory()->create();
        $data = [
            'name' => 'Technical',
            'description' => 'For technical links',
        ];
        $inventory = Inventory::factory()->for($user)->create($data);

        // Act
        $response = $this->actingAs($user)->from('/inventories')->delete("/inventories/{$inventory->id}");

        // Assert
        $response->assertRedirect('/inventories');
        $response->assertSessionHas('inventory.destroy', 'Inventory Deleted Successfully');

        $this->assertDatabaseCount('inventories', 0);
        $this->assertDatabaseMissing('inventories', [
            'user_id' => $user->id,
            ...$data,
        ]);
    }

    public function test_user_cannot_delete_another_user_inventory()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $data = [
            'name' => 'Technical',
            'description' => 'For technical links',
        ];

        $inventory = Inventory::factory()->for($userB)->create($data);

        // Act
        $response = $this->actingAs($userA)->from('/inventories')->delete("/inventories/{$inventory->id}");

        // Assert
        $response->assertNotFound();

        $this->assertDatabaseCount('inventories', 1);
        $this->assertDatabaseHas('inventories', [
            'user_id' => $userB->id,
            ...$data,
        ]);
    }
}
