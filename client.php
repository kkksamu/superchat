<?php

require 'vendor/autoload.php';

use Sockets\SocketClient as Client;
use Colorizer\Colors;

echo 'Enter your nickname: '. Colors::yellow();
$nickname = readline();
echo Colors::reset();

echo 'Enter clients IP: '. Colors::yellow();
$client_ip = readline();
echo Colors::reset();

echo 'Enter clients port: '. Colors::yellow();
$client_port = readline();
echo Colors::reset();

$client = new Client;
$client->connect ($client_ip, $client_port);

echo PHP_EOL;

while (true)
{
    echo '> '. Colors::yellow();
    $message = readline();
    echo Colors::reset();

    $client->send (serialize ([
        'message'  => $message,
        'nickname' => $nickname
    ]));
}

