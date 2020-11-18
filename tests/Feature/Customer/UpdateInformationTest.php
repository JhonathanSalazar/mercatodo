<?php

namespace Tests\Feature\Customer;

use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateInformationTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function aUserCanUpdateYourPersonalInformation() {

        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $name = $this->faker->firstName;
        $email = $this->faker->email;

        $this->put(route('pages.user-account.update', [
            'user' => $buyerUser->id,
            'name' => $name,
            'email' => $email
        ]));

        $buyerUser->refresh();

        $this->assertEquals($name, $buyerUser->name);
        $this->assertEquals($email, $buyerUser->email);
    }

    /**
     * @test
     */
    public function aUserCantUpdateInformationOfAnotherUser() {

        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser1 = factory(User::class)->create()->assignRole($buyerRole);
        $buyerUser2 = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser1);

        $name = $this->faker->firstName;
        $email = $this->faker->email;

        $response = $this->put(route('pages.user-account.update', [
            'user' => $buyerUser2->id,
            'name' => $name,
            'email' => $email
        ]));

        $response->assertStatus(403);

    }

}
