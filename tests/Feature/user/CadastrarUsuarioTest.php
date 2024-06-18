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
        'email' => fake()->email(),
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

it('validar os dados do emial', function () {

    $user = User::factory()->create();
    actingAs($user);

    // dados do novo usuário para cadstrar
    $userData = [
        'name' => 'Omerico Araújo',
        'email' => 'omerico@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ];

    // cadastrando usuário com sucesso
    post(route('users.store'), $userData)->assertSuccessful();


    $userData['email'] = 'Omerico@gmail.com';
    // validando email duplicado e com letra maiuscula 
    post(route('users.store'), $userData)->assertSessionHasErrors(
        [
            'email' => 'Este email já esta em uso!',
            'email' => 'O email deve conter apenas letras minusculas!'
        ]
    );


    $userData['email'] = null;
    // validando email vazio
    post(route('users.store'), $userData)->assertSessionHasErrors(
        [
            'email' => 'O email é obrigatório'
        ]
    );

    $userData['email'] = 'omericogmail.com';
    // validando email sem o @ e email vazio
    post(route('users.store'), $userData)->assertSessionHasErrors(
        [
            'email' => 'O email é obrigatório',
            'email' => 'Email invalido',
            // 'email' => 'O email deve conter menos de 255 caracteres',
        ]
    );

    $userData['email'] = str_repeat('w',256).'@gmail.com';
    // validando email com mais de 255 caracteres
    post(route('users.store'), $userData)->assertSessionHasErrors(
        [
            'email' => 'O email deve conter menos de 255 caracteres',
        ]
    );

});

it('o password não pode ser vazio', function () {

    $user = User::factory()->create();
    actingAs($user);

    // dados do novo usuário para cadstrar
    $userData = [
        'name' => 'Omerico Araújo',
        'email' => 'omerico@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'pass'
    ];

    // validando o password vazio e também password diferente de password_confirmation
    post(route('users.store', $userData))->assertSessionHasErrors([
        'password' => 'A senha é obrigatória',
        'password' => 'Os campos de senha são divergentes'
    ]);

    // atualizando o campo password_confirmation
    $userData['password_confirmation'] = 'password';
    // cadastrando novo usuário
    post(route('users.store', $userData))->assertSuccessful();
});
