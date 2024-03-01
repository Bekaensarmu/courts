<?php

/**
 * PHPMaker 2024 configuration file (Production)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "localhost", "port" => "3306", "user" => "root", "password" => "", "dbname" => "csdb"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "localhost", // SMTP server
        "SERVER_PORT" => 25, // SMTP server port
        "SECURE_OPTION" => "",
        "SERVER_USERNAME" => "", // SMTP server user name
        "SERVER_PASSWORD" => "", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "LYt8pX350ZBLHCz79C96W6uop1jnLdRWQUNMZ0y9iAg=", // JWT secret key
        "ALGORITHM" => "HS512", // JWT algorithm
        "AUTH_HEADER" => "X-Authorization", // API authentication header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
