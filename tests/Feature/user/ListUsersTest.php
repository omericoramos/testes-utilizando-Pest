<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('listar todos os usuários', function () {
    
    $user = User::factory()->create();
    actingAs($user);

    $listUsers = User::factory(10)->create();

    $response = get(route('users.index'))->assertSuccessful();

    /** @var User $user */
    foreach ($listUsers as $user) {
       $response->assertSee($user->all());
    }

});
