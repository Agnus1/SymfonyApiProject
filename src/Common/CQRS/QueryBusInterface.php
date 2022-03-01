<?php

namespace App\Common\CQRS;

interface QueryBusInterface
{
    public function dispatch(QueryInterface $query);
}