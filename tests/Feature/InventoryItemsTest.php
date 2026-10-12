<?php

use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryItemsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_item_to_his_inventory()
    {
        // Arrange
        $user = User::factory()->create();
        $inventory = Inventory::factory()->for($user)->create([
            'name' => 'Tech',
            'description' => 'For Tech',
        ]);
        $link = Link::factory()->for($user)->create([
            'title' => 'PHP',
            'description' => 'Learn PSR',
            'site_id' => 1,
            'status' => 0, // Not watched
            'url' => 'https://www.google.com',
        ]);
        $data = [
            'item' => $link->id,
            'inventory' => $inventory->id,
        ];

        // Act
        $response = $this->actingAs($user)->from('/links')->post('/invItems', $data);

        // Assert
        $response->assertRedirect('/links');
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('invMessage', 'Item stored successfully');

        $this->assertDatabaseHas('inventory_items', [
            'link_id' => $link->id,
            'inventory_id' => $inventory->id,
        ]);
        $this->assertDatabaseCount('inventory_items', 1);
    }

    public function test_user_cannot_add_item_to_another_user_inventory()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $inventory = Inventory::factory()->for($userB)->create([
            'name' => 'Tech',
            'description' => 'For Tech',
        ]);
        $link = Link::factory()->for($userA)->create([
            'title' => 'PHP',
            'description' => 'Learn PSR',
            'site_id' => 1,
            'status' => 0, // Not watched
            'url' => 'https://www.google.com',
        ]);
        $data = [
            'item' => $link->id,
            'inventory' => $inventory->id,
        ];

        // Act
        $response = $this->actingAs($userA)->from('/links')->post('/invItems', $data);

        // Assert
        $response->assertNotFound();

        $this->assertDatabaseMissing('inventory_items', [
            'link_id' => $link->id,
            'inventory_id' => $inventory->id,
        ]);
        $this->assertDatabaseCount('inventory_items', 0);
    }

    public function test_user_cannot_add_another_users_item_to_his_inventory()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $InvA = Inventory::factory()->for($userA)->create([
            'name' => 'Tech',
            'description' => 'For Tech',
        ]);
        $LinkB = Link::factory()->for($userB)->create([
            'title' => 'PHP',
            'description' => 'Learn PSR',
            'site_id' => 1,
            'status' => 0, // Not watched
            'url' => 'https://www.google.com',
        ]);

        $data = [
            'item' => $LinkB->id,
            'inventory' => $InvA->id,
        ];

        // Act
        $response = $this->actingAs($userA)->from('/links')->post('/invItems', $data);

        // Assert
        $response->assertNotFound();
        $this->assertDatabaseMissing('inventory_items', [
            'link_id' => $LinkB->id,
            'inventory_id' => $InvA->id,
        ]);
    }

    public function test_user_cannot_add_item_already_exits_in_his_inventory()
    {
        // Arrange
        $user = User::factory()->create();
        $inventory = Inventory::factory()->for($user)->create([
            'name' => 'Tech',
            'description' => 'For Tech',
        ]);
        $link = Link::factory()->for($user)->create([
            'title' => 'PHP',
            'description' => 'Learn PSR',
            'site_id' => 1,
            'status' => 0, // Not watched
            'url' => 'https://www.google.com',
        ]);
        InventoryItem::factory()->create([
            'inventory_id' => $inventory->id,
            'link_id' => $link->id,
        ]);

        $data = [
            'item' => $link->id,
            'inventory' => $inventory->id,
        ];

        // Act
        $response = $this->actingAs($user)->from('/links')->post('/invItems', $data);

        // Assert
        $response->assertRedirect('/links');
        $response->assertSessionHas('invMessage', 'This item is already at this inventory');

        $this->assertDatabaseHas('inventory_items', [
            'link_id' => $link->id,
            'inventory_id' => $inventory->id,
        ]);
        $this->assertDatabaseCount('inventory_items', 1);
    }

    public function test_user_can_remove_his_item_from_his_inventory()
    {
        // Arrange
        $user = User::factory()->create();
        $inventory = Inventory::factory()->for($user)->create([
            'name' => 'Tech',
            'description' => 'For Tech',
        ]);
        $link = Link::factory()->for($user)->create([
            'title' => 'PHP',
            'description' => 'Learn PSR',
            'site_id' => 1,
            'status' => 0, // Not watched
            'url' => 'https://www.google.com',
        ]);
        InventoryItem::factory()->create([
            'inventory_id' => $inventory->id,
            'link_id' => $link->id,
        ]);
        $data = [
            'item' => $link->id,
            'inventory' => $inventory->id,
        ];

        // Act
        $response = $this->actingAs($user)->from('/links')->delete('/invItems', $data);

        // Assert
        $response->assertRedirect('/links');
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('invMessage', "Item removed from {$inventory->name} successfully");

        $this->assertDatabaseMissing('inventory_items', [
            'link_id' => $link->id,
            'inventory_id' => $inventory->id,
        ]);
        $this->assertDatabaseCount('inventory_items', 0);
    }

    public function test_user_cannot_remove_another_user_item_from_his_inventory()
    {
        // Arrange
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $inventory = Inventory::factory()->for($userB)->create([
            'name' => 'Tech',
            'description' => 'For Tech',
        ]);
        $link = Link::factory()->for($userB)->create([
            'title' => 'PHP',
            'description' => 'Learn PSR',
            'site_id' => 1,
            'status' => 0, // Not watched
            'url' => 'https://www.google.com',
        ]);
        InventoryItem::factory()->create([
            'inventory_id' => $inventory->id,
            'link_id' => $link->id,
        ]);
        $data = [
            'item' => $link->id,
            'inventory' => $inventory->id,
        ];

        // Act
        $response = $this->actingAs($userA)->from('/links')->delete('/invItems', $data);

        // Assert
        $response->assertNotFound();

        $this->assertDatabaseHas('inventory_items', [
            'link_id' => $link->id,
            'inventory_id' => $inventory->id,
        ]);
        $this->assertDatabaseCount('inventory_items', 1);
    }

    public function test_user_cannot_remove_his_item_that_does_not_exist_in_his_inventory()
    {
        // Arrange
        $user = User::factory()->create();
        $inventory = Inventory::factory()->for($user)->create([
            'name' => 'Tech',
            'description' => 'For Tech',
        ]);
        $link = Link::factory()->for($user)->create([
            'title' => 'PHP',
            'description' => 'Learn PSR',
            'site_id' => 1,
            'status' => 0, // Not watched
            'url' => 'https://www.google.com',
        ]);
        $data = [
            'item' => $link->id,
            'inventory' => $inventory->id,
        ];

        // Act
        $response = $this->actingAs($user)->from('/links')->delete('/invItems', $data);

        // Assert
        $response->assertRedirect('/links');
        $response->assertSessionHas('invMessage', 'There is a problem at deleting');

        $this->assertDatabaseMissing('inventory_items', [
            'link_id' => $link->id,
            'inventory_id' => $inventory->id,
        ]);
        $this->assertDatabaseCount('inventory_items', 0);
    }

    public function test_user_cannot_remove_non_exist_item_from_his_inventory()
    {
        // Arrange
        $user = User::factory()->create();
        $inventory = Inventory::factory()->for($user)->create([
            'name' => 'Tech',
            'description' => 'For Tech',
        ]);
        $data = [
            'item' => 1,
            'inventory' => $inventory->id,
        ];

        // Act
        $response = $this->actingAs($user)->from('/links')->delete('/invItems', $data);

        // Assert
        $response->assertNotFound();
        $this->assertDatabaseMissing('inventory_items', [
            'link_id' => 1,
            'inventory_id' => $inventory->id,
        ]);
        $this->assertDatabaseCount('inventory_items', 0);
    }
}
