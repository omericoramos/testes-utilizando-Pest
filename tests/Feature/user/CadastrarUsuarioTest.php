<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('deve renderizar a tela de cadastro de usuário', function () {

    // Arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act     :: agir
    $response = get(route('users.create'));


    // Assert  :: verificar
    $response->assertSuccessful();
});

it('deve cadastrar um usuário com sucesso', function () {

    $user = User::factory()->create();
    actingAs($user);

   post(route('users.store'),[
        'name' => fake()->name(),
        'email' => 'omericoramos@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ])->assertSuccessful();
});

it('o nome do usuário deve ter mais de 2 caracteres e menos de 25', function () {
    //expect()->
})->todo();

it('o usuário devera estar logado para cadastrar um novo usuário', function () {
    //expect()->
})->todo();

it('o email deverá ser unico', function () {
    //expect()->
})->todo();

it('o password não pode ser vazio', function () {
    //expect()->
})->todo();

