<?php

declare(strict_types=1);

namespace App\Service;

class FibListService extends ListService
{
    
    protected function methodList(array $sourceContent): array
    {
        $fibSourceNumber = 2;
        $fibNumber = $this->initFirstFibNumber($fibSourceNumber);
        
        $finaleResponse = [];
        $i = 1;
        foreach ($sourceContent as $sourceItem) {
            while ($i == $fibNumber) {
                $finaleResponse[] = $this->getChuckNorrisJokeWithNumber($i);
                $fibSourceNumber++;
                $fibNumber = $this->calcFibonacci($fibSourceNumber);
            }
            $finaleResponse[] = array_merge(['number' => $i], $sourceItem);
            $i++;
        }
        return $finaleResponse;
    }
    
    private function initFirstFibNumber(int &$fibSourceNumber): int
    {
        do {
            $fibSourceNumber++;
            $fibNumber = $this->calcFibonacci($fibSourceNumber);
            
        } while ($fibNumber < 3);
        return $fibNumber;
    }
    
    private function calcFibonacci(int $number): int
    {
        if ($number < 3) {
            return $number;
        }
        return (int)round(pow((sqrt(5)+1)/2, $number) / sqrt(5));
    }
}