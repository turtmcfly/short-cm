<?php

namespace Turtmcfly\Short;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Ignittion\Short\Exceptions\ShortHttpException;

/**
 * Short.cm URL shortening service API.
 *
 * @package Short-cm
 * @author ignittion
 */
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
    protected function call(string $verb = 'GET', string $uri, array $body = [], array $query = [], array $additionalHeaders = [])
    {
        $apiUrl     = rtrim($this->api, '/') . '/' . ltrim($uri, '/');
        $headers    = array_merge($additionalHeaders, [
            'Content-Type'  => 'application/json',
            'Authorization' => $this->key,
        ]);
        $request    = ['headers'    => $headers];
        $verb       = strtoupper($verb);

        // append the default domain if we aren't given a custom one
        if ($verb == 'GET') {
            if ((isset($body['domain']) && is_null($body['domain'])) || ! isset($body['domain'])) {
                $query['domain']    = $this->domain;
            }
        } else {
            if ((isset($body['domain']) && is_null($body['domain'])) || ! isset($body['domain'])) {
                $body['domain']    = $this->domain;
            }
        }

        if (count($body)) {
            $request[RequestOptions::JSON]  = $body;
        }

        if (count($query)) {
            $request['query']   = $query;
        }

        $response   = $this->client->request($verb, $apiUrl, $request);

        return json_decode($response->getBody());
    }

    /**
     * Get a list of registered domains.
     *
     * @throws \Ignittion\Short\Exceptions\ShortHttpException when an
     *      \GuzzleHttp\Exception\ClientException is thrown.
     *
     * @see https://short.cm/api#/Domains/ApiDomainsGet
     *
     * @return array
     */
    public function domainList() : array
    {
        try {
            return $this->call('GET', 'api/domains');
        } catch (ClientException $e) {
            throw new ShortHttpException($e->getResponse());
        }
    }

    /**
     * Create a new short url.
     *
     * @see https://short.cm/api#/Link%20editing/LinksPost
     *
     * @param string $originalURL
     * @param string $title
     * @param string $path
     * @param array $tags
     * @param boolean $allowDuplicates
     * @param string $expiresAt
     * @param string $expiredURL
     * @param string $password
     * @param string $utmSource
     * @param string $utmMedium
     * @param string $utmCampaign
     * @param string $utmTerm
     * @param string $utmContent
     * @param string $domain
     * @return \stdClass
     */

    public function linkCreate(string $originalURL, string $title = null, string $path = null, array $tags = null,
            bool $allowDuplicates = null, string $expiresAt = null, string $expiredURL = null, string $password = null,
            string $utmSource = null, string $utmMedium = null, string $utmCampaign = null, string $utmTerm = null, string $utmContent = null, string $domain = null) : \stdClass
    {
        try {
            $body   = [];
            foreach (['originalURL', 'title', 'path', 'tags', 'allowDuplicates', 'expiresAt', 'expiredURL', 'password', 'utmSource',
                'utmMedium', 'utmCampaign', 'utmTerm', 'utmContent', 'domain'] as $item) {
                if (! is_null($$item)) {
                    $body[$item]    = $$item;
                }
            }
            return $this->call('POST', 'links', $body);
        } catch (ClientException $e) {
            throw new ShortHttpException($e->getResponse());
        }
    }

    /**
     * Delete a short url.
     *
     * @throws \Ignittion\Short\Exceptions\ShortHttpException when an
     *      \GuzzleHttp\Exception\ClientException is thrown.
     *
     * @see https://short.cm/api#/Link%20editing/LinksByLinkIdDelete
     *
     * @param integer $linkId
     * @return void
     */
    public function linkDelete(int $linkId)
    {
        try {
            return $this->call('DELETE', "links/{$linkId}");
        } catch (ClientException $e) {
            throw new ShortHttpException($e->getResponse());
        }
    }

    /**
     * Expand a short url by a given path.
     *
     * @throws \Ignittion\Short\Exceptions\ShortHttpException when an
     *      \GuzzleHttp\Exception\ClientException is thrown.
     *
     * @see https://short.cm/api#/Link%20queries/LinksExpandByDomainAndPathGet
     *
     * @param string $path
     * @param string $domain
     * @return \stdClass
     */
    public function linkExpand(string $path, string $domain = null) : \stdClass
    {
        try {
            $query  = [];
            foreach (['path', 'domain'] as $item) {
                if (! is_null($$item)) {
                    $query[$item]   = $$item;
                }
            }

            return $this->call('GET', 'links/expand', [], $query);
        } catch (ClientException $e) {
            throw new ShortHttpException($e->getResponse());
        }
    }

    /**
     * Expand a short url by the original url.
     *
     * @throws \Ignittion\Short\Exceptions\ShortHttpException when an
     *      \GuzzleHttp\Exception\ClientException is thrown.
     *
     * @see https://short.cm/api#/Link%20queries/LinksByOriginalUrlByDomainAndOriginalURLGet
     *
     * @param string $originalUrl
     * @param string $domain
     * @return \stdClass
     */
    public function linkExpandByLongUrl(string $originalURL, string $domain = null) : \stdClass
    {
        try {
            $query  = [];
            foreach (['originalURL', 'domain'] as $item) {
                if (! is_null($$item)) {
                    $query[$item]   = $$item;
                }
            }

            return $this->call('GET', 'links/by-original-url', [], $query);
        } catch (ClientException $e) {
            throw new ShortHttpException($e->getResponse());
        }
    }

    /**
     * Get statistics for a short url.
     *
     * @throws \Ignittion\Short\Exceptions\ShortHttpException when an
     *      \GuzzleHttp\Exception\ClientException is thrown.
     *
     * @see https://short.cm/api#/Link%20statistics/LinksStatisticsAPIByLinkIdAndPeriodGet
     *
     * @param integer $linkId
     * @param string $period
     * @return \stdClass
     */
    public function linkStats(int $linkId, string $period = 'total') : \stdClass
    {
        try {
            $query  = ['period' => $period];

            return $this->call('GET', "links/statistics/{$linkId}", [], $query);
        } catch (ClientException $e) {
            throw new ShortHttpException($e->getResponse());
        }
    }

    /**
     * Update an existing short url.
     *
     * @throws \Ignittion\Short\Exceptions\ShortHttpException when an
     *      \GuzzleHttp\Exception\ClientException is thrown.
     *
     * @see https://short.cm/api#/Link%20editing/LinksByLinkIdPost
     *
     * @param integer $linkId
     * @param string $originalURL
     * @param string $path
     * @param string $title
     * @param string $iphoneURL
     * @param string $androidURL
     * @param string $winmobileURL
     * @return \stdClass
     */
    public function linkUpdateExisting(int $linkId, string $originalURL, string $path = null, string $title = null,
        string $iphoneURL = null, string $androidURL = null, string $winmobileURL = null) : \stdClass
    {
        try {
            $body   = [];
            foreach (['originalURL', 'path', 'title', 'iphoneURL', 'androidURL', 'winmobileURL'] as $item) {
                if (! is_null($$item)) {
                    $body[$item]    = $$item;
                }
            }

            return $this->call('POST', "links/{$linkId}", $body);
        } catch (ClientException $e) {
            throw new ShortHttpException($e->getResponse());
        }
    }
}