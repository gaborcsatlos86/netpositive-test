<?php

declare(strict_types=1);

namespace App\Service;

abstract class ListService
{
    public function __construct(
        readonly private JsonPlaceholderService     $jsonPlaceholder,
        readonly private ChuckNorrisJokesService    $chuckNorrisJokes
    ) {}
    
    public function getList(int $userId1, int $userId2): array
    {
        $mergedContentById = [];
        $this->setItemsById($mergedContentById, $userId1);
        $this->setItemsById($mergedContentById, $userId2);
        
        arsort($mergedContentById);
        $mergedContentById = array_values($mergedContentById);
        
        return $this->methodList($mergedContentById);
    }
    
    abstract protected function methodList(array $sourceContent): array;
    
    protected function getChuckNorrisJokeWithNumber(int &$i): array
    {
        $contentItem = [
            'number' => $i,
            'source' => 'icndb',
            'message' => $this->chuckNorrisJokes->getContent()['value']
        ];
        $i++;
        return $contentItem;
    }
    
    private function setItemsById(&$mergedContentById, int $userId): void
    {
        $this->jsonPlaceholder->setUserId($userId);
        foreach ($this->jsonPlaceholder->getContent() as $jsonPlaceholderContent ) {
            $mergedContentById[$jsonPlaceholderContent['id']] = [
                'source' => 'jsonplaceholder/'. $userId,
                'messageId' => $jsonPlaceholderContent['id'],
                'message' => $jsonPlaceholderContent['body']
            ];
        }
    }
    
}
