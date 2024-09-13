<?php

declare(strict_types=1);

namespace App\Service;

class JsonPlaceholderService extends AbstractApiService implements ApiServiceInterface
{
    protected string $apiUrl = 'https://jsonplaceholder.typicode.com';
    protected string $endpoint = '/posts';
    
    private int $userId;
    
    public function getUserId(): int
    {
        return $this->userId;
    }
    
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        
        return $this;
    }
    
    public function getContent(): ?array
    {
        return $this->getRequest('userId='. $this->userId);
    }
}
