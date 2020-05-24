<?php

namespace App\Parser\Processor;

interface Processor
{
    public function getSiteData(string $html): array;
}