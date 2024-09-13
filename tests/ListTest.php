<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class ListTest extends WebTestCase
{
    private int $userId1;
    private int $userId2;
    
    private const FIB_NUMBERS = [3,5,8,13,21,34,55];
    
    protected function setUp(): void
    {
        $this->userId1 = rand(1, 19);
        $this->userId2 = $this->userId1 + 1;
    }
    
    public function testFirstLoad(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/'. $this->userId2 . '/' . $this->userId1, ['timeout' => 45]);
        
        $listSourceData = [];
        $others = $crawler->filter('td.data-source-info');
        foreach ($others->getIterator()->getArrayCopy() as $item) {
            $listSourceData[] = $item->textContent;
        }
        if (empty($listSourceData)) {
            $this->assertResponseIsUnprocessable('Empty list error');
        }
        foreach ($listSourceData as $key => $sourceItem) {
            if ($sourceItem == 'icndb' && !in_array(($key+1), self::FIB_NUMBERS)) {
                $this->assertResponseIsUnprocessable();
            }
        }
        $this->assertResponseIsSuccessful();
    }
    
    public function testSameId(): void
    {
        $client = static::createClient();
        $client->request('GET', '/'. $this->userId1 . '/' . $this->userId1, ['timeout' => 45]);
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'Érvénytelen paramétert adott meg! A két értéknek különbözőnek kell lennie!');
    }
    
    public function testInvalidMethod(): void
    {
        $client = static::createClient();
        $client->request('GET', '/'. $this->userId2 . '/' . $this->userId1. '/sdfsfds', ['timeout' => 45]);
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'Érvénytelen paramétert adott meg! A method csak fib vagy mod értéket vehet fel!');
    }
    
    public function testModList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/'. $this->userId2 . '/' . $this->userId1. '/mod', ['timeout' => 45]);
        
        $listSourceData = [];
        $others = $crawler->filter('td.data-source-info');
        foreach ($others->getIterator()->getArrayCopy() as $item) {
            $listSourceData[] = $item->textContent;
        }
        if (empty($listSourceData)) {
            $this->assertResponseIsUnprocessable('Empty list error');
        }
        foreach ($listSourceData as $key => $sourceItem) {
            if ($sourceItem == 'icndb' && (($key+1) % 3) != 0) {
                $this->assertResponseIsUnprocessable();
            }
        }
        $this->assertResponseIsSuccessful();
    }
    
}
