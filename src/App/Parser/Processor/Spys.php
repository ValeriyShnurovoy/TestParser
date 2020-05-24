<?php

namespace App\Parser\Processor;

class Spys implements Processor
{
    protected $convertData = [
        'EightNineNineEight^Zero6Nine',
        'ZeroFourSixNine^Seven4Five',
        'FiveEightFiveThree^EightSixTwo',
        'ZeroNineThreeTwo^FourThreeEight',
        'Four3OneZero^Six8Seven',
        'ThreeSixEightSix^FiveTwoZero',
        'NineFourTwoOne^Seven1One',
        'FourOneZeroSeven^SevenOneFour',
        'Two4FourFive^FourSixThree',
        'TwoSevenSevenFour^Five0Six'
    ];

    public function getSiteData(string $html): array
    {
        $result = [];
        $eachMarket = true;
        $startPosition = strpos($html, 'Proxy address:port');
        $endPosition = strpos($html, '*NOA - non anonymous proxy', $startPosition) - 33;

        while($eachMarket) {
            $position = strpos($html, '<tr', $startPosition);

            if (false === $position) {
                $eachMarket = false;
                break;
            }

            $ipWithPort = $this->getIpWithPort($position, $html);

            $result[] = [
                'ip' => $this->getIp($ipWithPort),
                'port' => $this->getPort($this->slicePost($ipWithPort)),
                'proxyType' => $this->getProxyType($position, $html),
                'anonymity' => $this->getAnonymity($position, $html),
                'country' => $this->getCountry($position, $html),
            ];

            $startPosition = $this->getEndLine($position, $html);

            if ($startPosition > $endPosition) {
                $eachMarket = false;
                break;
            }
        }

        return $result;
    }

    protected function getIpWithPort(int $position, string $html): string
    {
        $result = false;
        $positionFirstTd = strpos($html, '<td', $position);
        $positionEndSecondTd = strpos($html, 'td><td', $positionFirstTd);
        if (false !== $positionFirstTd && false != $positionEndSecondTd) {
            $result = strip_tags(substr($html, ($positionFirstTd), $positionEndSecondTd - ($positionFirstTd)));
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

    protected function getPort(string $ipWithPort): string
    {
        $result = '';
        $eachmarker = true;

        while ($eachmarker) {
            $positionStart = strpos($ipWithPort, '(');
            if ($positionStart) {
                $eachmarker = false;
                break;
            }
            $positionFinish = strpos($ipWithPort, ')');
            $port = substr($ipWithPort, $positionStart + 1, $positionFinish - $positionStart - 1);
            $ipWithPort = substr($ipWithPort, $positionFinish + 1);
            $result = $result . array_search($port, $this->convertData);
        }

        return $result;
    }

    protected function getProxyType(int $position, string $html): string
    {
        $result = '';
        $positionEndFirstTd = strpos($html, 'td><td', $position);
        $positionEndSecondTd = strpos($html, 'td><td', $positionEndFirstTd + 5);

        if (false !== $positionEndFirstTd && false !==  $positionEndSecondTd) {
            $result = strip_tags(substr($html, ($positionEndFirstTd + 3), $positionEndSecondTd - ($positionEndFirstTd)));
        }

        return $result;
    }

    protected function getAnonymity(int $position, string $html): string
    {
        $result = '';
        $positionEndFirstTd = strpos($html, 'td><td', $position);
        $positionEndSecondTd = strpos($html, 'td><td', $positionEndFirstTd + 5);
        $positionEndThirdTd = strpos($html, 'td><td', $positionEndSecondTd + 5);

        if (false !== $positionEndSecondTd && false !==  $positionEndThirdTd) {
            $result = strip_tags(substr($html, ($positionEndSecondTd + 3), $positionEndThirdTd - ($positionEndSecondTd)));
        }

        return $result;
    }

    protected function getCountry(int $position, string $html): string
    {
        $result = '';
        $positionEndFirstTd = strpos($html, 'td><td', $position);
        $positionEndSecondTd = strpos($html, 'td><td', $positionEndFirstTd + 5);
        $positionEndThirdTd = strpos($html, 'td><td', $positionEndSecondTd + 5);
        $positionEndFourTd = strpos($html, 'td><td', $positionEndThirdTd + 5);

        if (false !== $positionEndThirdTd && false !== $positionEndFourTd) {
            $result = strip_tags(substr($html, ($positionEndThirdTd + 3), $positionEndFourTd - ($positionEndThirdTd)));
        }

        return $result;
    }

    protected function slicePost(string $ipWithPort): string
    {
        $delimetrPos = strpos($ipWithPort, 'document.write');
        return substr($ipWithPort, $delimetrPos + 19);
    }

    protected function getEndLine(int $position, string $html): int
    {
        return strpos($html, 'tr>', $position + 10);
    }
}