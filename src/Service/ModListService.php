<?php

declare(strict_types=1);

namespace App\Service;

class ModListService extends ListService
{
    protected function methodList(array $sourceContent): array
    {
        $finaleResponse = [];
        $i = 1;
        foreach ($sourceContent as $key => $sourceItem) {
            $finaleResponse[] = array_merge(['number' => $i], $sourceItem);
            $i++;
            if ($key > 0 && (($key+1) % 2) == 0) {
                $finaleResponse[] = $this->getChuckNorrisJokeWithNumber($i);
            }
        }
        
        return $finaleResponse;
    }
}