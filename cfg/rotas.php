<?php

$rotas = [

    //Primeira page mostrada ao acessae
    //http://localhost/web3/carolla-food/
    '/' => [
        'GET' => '\Controlador\RaizControlador#index',
    ],

    //---------------------------------------rotas de usuários---------------------------------------//


     //Tela de login
     //http://localhost/web3/carolla-food/login
     '/login' => [
        'GET' => '\Controlador\LoginControlador#criar',
        'POST' => '\Controlador\LoginControlador#armazenar',
        'DELETE' => '\Controlador\LoginControlador#destruir'
    ],


    //Cadastrar usuários
     //http://localhost/web3/carolla-food/usuarios/criar
    '/usuarios/criar' => [
        'GET' => '\Controlador\UsuarioControlador#criar',
        'POST' => '\Controlador\UsuarioControlador#armazenar',
     ],


    //---------------------------------------rotas de receitas---------------------------------------//


    //Listagem das receitas já adicionadas no sistema
    //http://localhost/web3/carolla-food/receitas
    '/receitas' => [
        'GET' => '\Controlador\ReceitaControlador#index',
    ],

    //Cadastrar receitas
    //http://localhost/web3/carolla-food/receita/criar
    '/receitas/criar' => [
        'GET' => '\Controlador\ReceitaControlador#criar',
        'POST' => '\Controlador\ReceitaControlador#armazenar',
     ],

     //Page mostrada quando clicar em alguma receita
     //http://localhost/web3/carolla-food/receita/1
     '/receitas/?' => [
        'GET' => '\Controlador\ReceitaControlador#mostrar',
        'POST' => '\Controlador\ReceitaControlador#armazenar',
        'DELETE' => '\Controlador\ReceitaControlador#destruir'
     ],

     //---------EDITAR ESTA OK.... VER O ?
     //Tela de editar a receita
     //http://localhost/web3/carolla-food/receita/editar
     '/receitas/?/editar' => [
        'GET' => '\Controlador\ReceitaControlador#editar',
        'POST' => '\Controlador\ReceitaControlador#atualizar',
     ],


    '/receitas/filtrar' => [
        'POST' => '\Controlador\ReceitaControlador#filtrar',
    ],


    '/receitas/?/comentarios' => [
        'POST' => '\Controlador\ComentarioControlador#armazenar',
     ],

     '/receitas/?/comentarios/?' => [
        'DELETE' => '\Controlador\ComentarioControlador#destruir',
     ],





];
