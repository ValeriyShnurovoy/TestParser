<?php

namespace App\Parser\Processor;

use Symfony\Component\DomCrawler\Crawler;


class SpysQuery implements Processor
{

    public function getSiteData(string $html): array
    {
        $result = [];

        $crawler = new Crawler();
        $crawler->addHtmlContent($html);
        $tableContent = $crawler->filterXPath('//table/tr/td/table')->children();

        for ($i = 3; $i < $tableContent->count() - 1; $i++) {
            $node = $tableContent->getNode($i);
            $nodeCrawler = new Crawler($node);
            $tdContent = $nodeCrawler->filterXPath('tr/td');
            $result[] = [
                'ip' => $this->getIp($tdContent->getNode(0)->nodeValue),
                'port' => '',
                'proxyType' => $tdContent->getNode(1)->nodeValue,
                'anonymity' => $tdContent->getNode(2)->nodeValue,
                'country' => $tdContent->getNode(3)->nodeValue,
            ];
        }
        
        return $result;
    }

    protected function getIp(string $ipWithPort): string
    {
        $result = '';
        $delimetrPos = strpos($ipWithPort, 'document.write');
        if (false !== $delimetrPos) {
            $result = substr($ipWithPort, 0, $delimetrPos);
        }

        return $result;
    }

}