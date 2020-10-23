<?php

namespace Tests\Feature\Customer;

use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EditInformationTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function aUserCanViewYourPersonalInformation() {

        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $response = $this->get(route('pages.user-account.edit', $buyerUser->id));

        $response->assertStatus(200)
            ->assertSee($buyerUser->name)
            ->assertSee($buyerUser->email);
    }

    /**
     * @test
     */
    public function aUserCantViewInformationOfAnotherUser() {

        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser1 = factory(User::class)->create()->assignRole($buyerRole);
        $buyerUser2 = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser1);

        $this->get(route('pages.user-account.edit', $buyerUser2->id))
        ->assertStatus(403);
    }
}
