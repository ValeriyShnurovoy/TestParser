<?php

namespace App\Parser\Transport;

class Transport
{

    const STATUS_OK = '200';

    protected $curlInfo;

    public function getParseData(string $urlAdress, bool $emulation = false): string
    {
        $ch = curl_init($urlAdress);
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
        if ($emulation) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getEmulationString());
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        $html = curl_exec($ch);
        $this->curlInfo = curl_getinfo($ch);
        curl_close($ch);

        return $html;
    }


    public function getParseStatus(): string
    {
        $result = false;
        if (!empty($this->curlInfo)) {
            $result = $this->curlInfo['http_code'];
        }

        return $result;
    }


    protected function getEmulationString(): array
    {
        return [
            'cache-control: max-age=0',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
            'sec-fetch-user: ?1',
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'x-compress: null',
            'sec-fetch-site: none',
            'sec-fetch-mode: navigate',
            'accept-encoding: deflate, br',
            'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
        ];
    }

}