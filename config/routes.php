<?php

    # _____________ Configuración de rutas del sistema ________________________
    # acción recibida por $_GET['action']

return [
    'index' => [
        'vista' => 'login.php',
        'menu'  => false,
        'roles' => ['*']
    ],
    'home' => [
        'vista' => 'home.php',
        'menu'  => true,
        // 'roles' => ['admin', 'usuario']
        'roles' => ['*']
    ],
    'usuarios' => [
        'vista' => 'usuarios/usuarios.php',
        'menu'  => true,
        'roles' => ['1']
    ],
    'reportes' => [
        'vista' => 'reportes/reportes.php',
        'menu'  => true,
        'roles' => ['admin', 'supervisor']
    ],
    'clientes' => [
        'vista' => 'clientes/clientes.php',
        'menu'  => true,
        'roles' => [1, 2] 
    ],
    'vendedores' => [
        'vista' => 'vendedores/vendedores.php',
        'menu'  => true,
        'roles' => [1] // Solo el Superusuario o el Administrador puede entrar aquí
    ],
        'producto' => [
        'vista' => 'producto/producto.php',
        'menu'  => true,
        'roles' => ['*'] // Solo el Superusuario o el Administrador puede entrar aquí
    ],
        'pedido' => [
        'vista' => 'pedido/pedido.php',
        'menu'  => true,
        'roles' => ['*'] // Solo el Superusuario o el Administrador puede entrar aquí
    ],
    'salir' => [
        'vista' => 'salir.php',
        'menu'  => false,
        'roles' => ['*'] // Todos pueden cerrar sesion
    ]
];
