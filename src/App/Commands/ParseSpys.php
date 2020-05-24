<?php

namespace App\Commands;

use App\Parser\Manager;
use AppBundle\Entity\Proxy;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseSpys extends ContainerAwareCommand
{
    /*
    * Default command name
    */
    protected static $defaultName = 'parseSpys';

    protected function configure()
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription("Parse site Spys")
            ->setHelp('Parse site Spys');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output):void
    {
        $manager = new Manager();
        $data = $manager->parseSiteData();

        foreach ($data as $line) {
            extract($line, EXTR_OVERWRITE);
            $proxy = new Proxy();
            $proxy->setIp($ip);
            $proxy->setPort($port);
            $proxy->setProxyType($proxyType);
            $proxy->setAnonymity($anonymity);
            $proxy->setCountry($country);

            $doctrine = $this->getContainer()->get('doctrine');
            $em = $doctrine->getManager();
            $em->persist($proxy);
            $em->flush();
        }
    }
}