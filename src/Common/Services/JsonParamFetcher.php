<?php

namespace App\Common\Services;

use App\Common\Exceptions\RequestException;

class JsonParamFetcher implements ParamFetcherInterface
{
    private string $content;
    private const DEFAULT_JSON_DEPTH = 512;

    /**
     * @param string $content
     * @return void
     */
    public function setContent(string $content) : void
    {
        $this->content = $content;
    }

    /**
     * @return array
     * @throws RequestException
     */
    public function getParams() : array
    {
        $params = json_decode($this->content, true, self::DEFAULT_JSON_DEPTH);
        if (is_null($params)) {
            throw (new RequestException())->setErrorBag(["fetching error invalid json format"]);
        }

        return $params;
    }
}