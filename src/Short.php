<?php

namespace Ignittion\Short;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;

class Short
{
    /**
     * The API URL.
     *
     * @var string
     */
    protected $api;

    /**
     * The Short URL domain.
     *
     * @var string|null
     */
    protected $domain;

    /**
     * The GuzzleHttp Client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * The API Key.
     *
     * @var string
     */
    protected $key;

    /**
     * Constructor
     *
     * @param string $api
     * @param string $domain
     * @param string $key
     * @return void
     */
    public function __construct(string $api, string $domain, string $key)
    {
        $this->api      = $api;
        $this->domain   = $domain;
        $this->client   = new GuzzleClient;
        $this->key      = $key;
    }

    /**
     * Make a request to the API and return the response.
     *
     * @param string $verb
     * @param string $uri
     * @param array $body
     * @param array $query
     * @param array $additionalHeaders
     * @return \stdClass
     */
    protected function call(string $verb = 'GET', string $uri, array $body = [], array $query = [], array $additionalHeaders = []) : \stdClass
    {
        $apiUrl     = rtrim($this->api, '/') . '/' . ltrim($uri, '/');
        $headers    = array_merge($additionalHeaders, [
            'Content-Type'  => 'application/json',
            'Authorization' => $this->key,
        ]);
        $request    = [];
        $verb       = strtoupper($verb);

        if (count($body)) {
            $request[RequestOptions::JSON]  = $body;
        }

        if (count($query)) {
            $request['query']   = $query;
        }

        $response   = $client->request($$verb, $apiUrl, $request);

        return json_decode($response);
    }

    /**
     * Get a list of registered domains.
     *
     * @return \stdClass
     */
    public function domainList() : \stdClass
    {
        return $this->call('GET', 'api/domains');
    }
}