<?php

declare(strict_types=1);

namespace App\CQRS;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
