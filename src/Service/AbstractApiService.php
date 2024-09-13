<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractApiService
{
    protected const REQUEST_STATUS_OK = 200;
    
    protected string $apiUrl;
    protected string $endpoint;
    
    public function __construct(
        protected HttpClientInterface $client,
    ) {}
    
    protected function getRequest(?string $queryParams = null): ?array
    {
        $url = $this->apiUrl . $this->endpoint . (($queryParams !== null) ? '?'.$queryParams : '');
        $response = $this->client->request(
            Request::METHOD_GET,
            $url
        );
        
        if ($response->getStatusCode() != self::REQUEST_STATUS_OK) {
            throw new BadRequestHttpException('The response from '. $url . ' was bad');
        }
        
        return $response->toArray();
    }
    
}
