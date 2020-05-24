<?php

namespace App\Parser;

use App\Parser\Saver\SpysBd;
use App\Parser\Transport\Transport;
use App\Parser\Processor\Spys;

class Manager
{
    const SPYS_URL = 'http://spys.one/free-proxy-list/ALL/';

    public function parseSiteData(): array
    {
        $transport = new Transport();
        $processor = new Spys();
        $saver = new SpysBd();
        $i = 0;
        $eachMarker = true;
        $result = [];
        while($eachMarker) {
            if ($i > 0) {
                $url = self::SPYS_URL.$i.'/';
            } else {
                $url = self::SPYS_URL;
            }
            $html = $transport->getParseData($url, true);
            if ($transport::STATUS_OK !== $transport->getParseStatus()) {
                $eachMarker = false;
                break;
            }
            $siteData = $processor->getSiteData($html);
            $result = array_merge($result, $siteData);
            $i++;
        }

        return $result;
    }
}