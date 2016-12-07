<?php

require_once __DIR__ . '/vendor/autoload.php';

use Blackfire\LoopClient;
use Blackfire\Client;
use Blackfire\Profile\Configuration as ProfileConfiguration;

function consume()
{
    echo "Message consumed!\n";
    $data = json_decode('{"foo": "bar"}');
    file_put_contents('data', $data);
    usleep(400000);
}

$blackfire = new LoopClient(new Client(), 10);
$blackfire->setSignal(SIGUSR1);
$profileConfig = new ProfileConfiguration();
$profileConfig->setTitle('Consumer');

for (;;) {
    $blackfire->startLoop($profileConfig);

    consume();

    if ($profile = $blackfire->endLoop()) {
        print $profile->getUrl()."\n";
    }
}