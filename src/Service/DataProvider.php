<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class DataProvider
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getData()
    {
        $httpClient = HttpClient::create();
        $content = [];

        try {
            $response = $httpClient->request('GET', 'someurl');

            if (200 !== $response->getStatusCode()) {
                $this->logger->error('Error: HTTP response code is ' . $response->getStatusCode());
            } else {
                $content = $response->toArray();
            }

        } catch (TransportExceptionInterface | ClientExceptionInterface | DecodingExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface $exception ) {
            $this->logger->error($exception->getMessage());
        }

        return $content;

    }
}