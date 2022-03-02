<?php

namespace App\Common\CQRS;

interface QueryBusInterface
{
    /**
     * @param QueryInterface $query
     * @return mixed
     */
    public function dispatch(QueryInterface $query);
}