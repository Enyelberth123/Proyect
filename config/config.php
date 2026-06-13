<?php

// Configuramos la cookie de sesión para que dure: (60 seg * 60 min * 24 horas * 30 días)
session_set_cookie_params(60 * 60 * 24 * 30);

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}
if ( !isset( $_SESSION ) ) { session_start(); }
if ( isset($_SESSION['database']) ) {

	$database = $_SESSION['database'];
} else {

	$database = 'prueba';
    // $database = 'educativo';
}

$databaseAnterior = 'baseAntigua';

$config = [

    "database" => [

      "driver"     => "mysql",
      "host"     => "localhost",
      "port"     => "3306",
      "dbname"   => $database,
      "username" => "root",
      "password" => ""
    ],
    "mailer" => [

      "smtp_debug"      => false,
      "host"            => "smtp.gmail.com",
      "smtp_auth"       => true,
      "username"        => "correo@gmail.com",
      "password"        => "123456",
      "smtp_secure"     => "ssl",
      "port"            => 465,
      "reply_to_email"  => "correo@gmail.com",
      "reply_to_name"   => "Uptaeb",
      "from_email"      => "correo@gmail.com",
      "from_name"       => "Uptaeb"
    ],
];

$configAnterior = [

    "database" => [

      "driver"     => "mysql",
      "host"     => "localhost",
      "port"     => "3306",
      "dbname"   => $databaseAnterior,
      "username" => "root",
      "password" => ""
    ],
    "mailer" => [

      "smtp_debug"      => false,
      "host"            => "smtp.gmail.com",
      "smtp_auth"       => true,
      "username"        => "correo@gmail.com",
      "password"        => "123456",
      "smtp_secure"     => "ssl",
      "port"            => 465,
      "reply_to_email"  => "correo@gmail.com",
      "reply_to_name"   => "Uptaeb",
      "from_email"      => "correo@gmail.com",
      "from_name"       => "Uptaeb"
    ],
];