<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework) {

    $framework->messenger()->defaultBus('command.bus');

    $framework->messenger()->bus('command.bus');
    $framework->messenger()->bus('query.bus');

    $framework->messenger()->transport('sync')->dsn('sync://');
    $framework->messenger()->transport('async')->dsn($_ENV['MESSENGER_TRANSPORT_DSN']);
};
