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

    post(route('users.store'), [
        'name' => fake()->name(),
        'email' => 'omericoramos@hotmail.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ])->assertSuccessful();
});

it('o nome do usuário deve ter mais de 2 caracteres e menos de 25', function () {

    $user = User::factory()->create();
    actingAs($user);

    // dados do novo usuário para cadstrar
    $userData = [
        'name' => 'ka',
        'email' => fake()->email(),
        'password' => 'password',
        'password_confirmation' => 'password'
    ];

    // retorna a mensagem de erro de caracteres minimos
    post(route('users.store', $userData),)->assertSessionHasErrors(
        ['name' => 'O nome do usuário deve conter no minimo 3 caracteres!']
    );


    // caso queria utilizar o validate direto no controller sem menssagem customizada: 
    // $request->assertSessionHasErrors([
    //     'name' => __('validation.min.string', ['min' => 3, 'attribute' => 'name'])
    // ]);


    // altera o nome do usuário para que fique com mais de 25 caractres
    $userData['name'] = str_repeat('3', 30);

    // retorna a mensagem de erro de caracteres maximos ultatrapassado
    post(route('users.store'), $userData)->assertSessionHasErrors(
        ['name' => 'O nome do usuário deve conter no maximo 25 caracteres!']
    );
});

it('o usuário devera estar logado para cadastrar um novo usuário', function () {
    //expect()->
})->todo();

it('o email deverá ser unico', function () {
    //expect()->
})->todo();

it('o password não pode ser vazio', function () {
    //expect()->
})->todo();
