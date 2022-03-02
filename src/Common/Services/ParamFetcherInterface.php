<?php

namespace App\Common\Services;

interface ParamFetcherInterface
{
    public function setContent(string $content) : void;
    public function getParams() : array;
}