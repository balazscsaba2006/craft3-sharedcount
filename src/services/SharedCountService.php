<?php

namespace humandirect\sharedcount\services;

use craft\base\Component;
use humandirect\sharedcount\lib\SharedCountClient;
use humandirect\sharedcount\lib\SharedCountClientException;
use humandirect\sharedcount\SharedCount;

/**
 * Class SharedCountService
 *
 * @author    Balazs Csaba <csaba.balazs@humandirect.eu>
 * @copyright 2018 Human Direct
 */
class SharedCountService extends Component
{
    /**
     * Fetches shares/likes for given URL from SharedCount.com
     *
     * @param string $url
     * @param array  $options
     *
     * @return array
     *
     * @throws SharedCountClientException
     * @throws \InvalidArgumentException
     */
    public function likes(string $url, array $options = []): array
    {
        if (empty($url)) {
            throw new \InvalidArgumentException('You didn\'t specify a valid URL parameter.');
        }

        $settings = SharedCount::$plugin->getSettings();
        $client = new SharedCountClient($settings->apiKey);

        try {
            $response = $client->getLikes($url, $options);
        } catch (\Exception $e) {
            return [];
        }

        return $this->lowercaseKeys(json_decode($response->getBody(), true));
    }

    /**
     * Normalize array key capitalization
     *
     * @param array $result
     *
     * @return array
     */
    private function lowercaseKeys(array $result = []): array
    {
        $values = [];
        foreach ($result as $key => $value) {
            $values[strtolower($key)] = $value;
        }

        return $values;
    }
}
