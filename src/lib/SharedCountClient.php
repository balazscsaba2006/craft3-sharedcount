<?php

namespace humandirect\sharedcount\lib;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class SharedCountClient
 *
 * @package humandirect\sharedcount\lib
 */
class SharedCountClient extends GuzzleClient
{
    /**
     * Client constructor.
     *
     * @param string $apiKey
     * @param array $config
     *
     * @throws SharedCountClientException
     */
    public function __construct(string $apiKey, array $config = [])
    {
        if (empty($apiKey)) {
            throw new SharedCountClientException('Api key cannot be empty.');
        }

        // add api key as default query parameter
        $handler = HandlerStack::create();
        $handler->unshift(Middleware::mapRequest(function (RequestInterface $request) use ($apiKey) {
            return $request->withUri(
                Uri::withQueryValue($request->getUri(), 'apikey', $apiKey)
            );
        }));

        $config['base_uri'] = 'https://api.sharedcount.com/v1.0/';
        $config['handler'] = $handler;

        parent::__construct($config);
    }

    /**
     * @param string $url
     * @param array  $options
     *
     * @return ResponseInterface
     * @throws SharedCountClientException
     */
    public function getLikes(string $url, array $options = []): ResponseInterface
    {
        $options['query'] = ['url' => $url];

        try {
            return $this->get('/', $options);
        } catch (\Exception $e) {
            throw new SharedCountClientException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
