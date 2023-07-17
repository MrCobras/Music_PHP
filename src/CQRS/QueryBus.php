<?php

namespace App\CQRS;

interface QueryBus
{
    public function handle(Query $query): mixed;
}
