<?php

require 'vendor/autoload.php';

use Sockets\SocketListener as Listener;
use Colorizer\Colors;

$listener = new Listener (53874);

$i = 0;
$client = $listener->acceptAsync()->call(function () use (&$i)
{
    if (++$i == 10)
        return false;
    
    echo 'Waiting for connections... ('. $i .')' . PHP_EOL;
    sleep (1);

    return true;
});

if ($client === null)
    die ('Client not connected');

echo Colors::format ('[green]Client connected[reset]'). PHP_EOL . PHP_EOL;

while (true)
{
    try
    {
        $messages = @$client->read ();
    }

    catch (\Exception $e)
    {
        continue;
    }

    foreach ($messages as $message)
    {
        $message = unserialize ($message);

        echo Colors::cyan () . $message['nickname'] . Colors::black (true) .' > '. Colors::reset () . $message['message'] . PHP_EOL;
    }

    sleep (1);
}
