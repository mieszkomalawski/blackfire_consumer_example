<?php

require_once __DIR__ . '/vendor/autoload.php';

use Blackfire\LoopClient;
use Blackfire\Client;
use Blackfire\Profile\Configuration as ProfileConfiguration;

function consume()
{
    echo "Message consumed!\n";
}

$blackfire = new LoopClient(new Client(), 10);
$profileConfig = new ProfileConfiguration();
$profileConfig->setTitle('Consumer');

for (;;) {
    $blackfire->startLoop($profileConfig);

    consume();

    if ($profile = $blackfire->endLoop()) {
        print $profile->getUrl()."\n";
    }

    usleep(400000);
}