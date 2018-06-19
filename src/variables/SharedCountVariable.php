<?php

namespace humandirect\sharedcount\variables;

use humandirect\sharedcount\lib\SharedCountClientException;
use humandirect\sharedcount\SharedCount as Plugin;

/**
 * SharedCountVariable class
 *
 * @author    Balazs Csaba <csaba.balazs@humandirect.eu>
 * @copyright 2018 Human Direct
 */
class SharedCountVariable
{
    /**
     * @param string $url
     *
     * @return array
     *
     * @throws SharedCountClientException
     * @throws \InvalidArgumentException
     */
    public function likes(string $url): array
    {
        return Plugin::$plugin->sharedcount->likes($url);
    }
}
