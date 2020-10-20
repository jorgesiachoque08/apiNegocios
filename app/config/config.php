<?php

/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');
$tokenId    = base64_encode(random_bytes(32));
$issuedAt   = time();
$notBefore  = $issuedAt + 1;             //Adding 1 seconds
$expire     = $notBefore + (60*60);            // Adding 10 seconds
$serverName = $_SERVER['SERVER_NAME'];

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => 'jorgesiachoque08',
        'dbname'      => 'db_negocios',
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => APP_PATH . '/cache/',
        'componentesDir'       => APP_PATH . '/componentes/',
        'baseUri'        => '/',
    ],
    'jwt' => [
        "key"=>'123456789QWERTYUIOPASDFGHJKLZXCVBNM',
        "data" => array(
            'iat'  => $issuedAt,         // Issued at: time when the token was generated
            'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
            'iss'  => $serverName,       // Issuer
            'nbf'  => $notBefore,        // Not before
            'exp'  => $expire,            // Expire
            'data'=> null
        )

    ]
]);
