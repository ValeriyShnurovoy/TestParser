<?php

namespace App\Parser\Saver;


use App\Controller\Proxy;

class SpysBd implements Saver
{
    public function saveData(array $data)
    {
        foreach ($data as $line) {
            $proxy = new Proxy();
            $proxy->saveProxy($line);
        }
    }

}