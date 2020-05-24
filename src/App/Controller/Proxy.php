<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Proxy As ProxyEntity;
use Symfony\Component\Config\Definition\Exception\Exception;


class Proxy extends Controller
{
    public function saveProxy(array $data):void
    {
        try {
            extract($data, EXTR_OVERWRITE);
            $proxy = new ProxyEntity();
            $proxy->setIp($ip);
            $proxy->setPort($port);
            $proxy->setProxyType($proxyType);
            $proxy->setAnonymity($anonymity);
            $proxy->setCountry($country);

            $em = $this->getDoctrine()->getManager();
            $em->persist($proxy);
            $em->flush();
        } catch (Exception $e) {
            echo $e->getMessage(), "\n";
        }
    }
}