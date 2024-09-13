<?php

declare(strict_types=1);

namespace App\Service;

class ChuckNorrisJokesService extends AbstractApiService implements ApiServiceInterface
{
    protected string $apiUrl = 'https://api.chucknorris.io';
    protected string $endpoint = '/jokes/random';
    
    public function getContent(): ?array
    {
        return $this->getRequest();
    }

}
