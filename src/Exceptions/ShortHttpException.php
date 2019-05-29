<?php

namespace Turtmcfly\Short\Exceptions;

use Exception;
use GuzzleHttp\Psr7\Response;

class ShortHttpException extends Exception
{
    /**
     * A user-friendly exception to through if we receive an error from GuzzleHttp.
     *
     * @param \GuzzleHttp\Psr7\Response $response
     * @param integer $code
     * @param \Exception $previous
     */
    public function __construct(Response $response, int $code = 0, Exception $previous = null)
    {
        $message    = json_decode($response->getBody()->__toString());

        parent::__construct($message->error, $code, $previous);
    }
}