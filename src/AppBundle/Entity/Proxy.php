<?php

namespace AppBundle\Entity;

/**
 * Proxy
 */
class Proxy
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $port;

    /**
     * @var string
     */
    private $proxy_type;

    /**
     * @var string
     */
    private $anonymity;

    /**
     * @var string
     */
    private $country;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Proxy
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set port
     *
     * @param string $port
     *
     * @return Proxy
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set proxyType
     *
     * @param string $proxyType
     *
     * @return Proxy
     */
    public function setProxyType($proxyType)
    {
        $this->proxy_type = $proxyType;

        return $this;
    }

    /**
     * Get proxyType
     *
     * @return string
     */
    public function getProxyType()
    {
        return $this->proxy_type;
    }

    /**
     * Set anonymity
     *
     * @param string $anonymity
     *
     * @return Proxy
     */
    public function setAnonymity($anonymity)
    {
        $this->anonymity = $anonymity;

        return $this;
    }

    /**
     * Get anonymity
     *
     * @return string
     */
    public function getAnonymity()
    {
        return $this->anonymity;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Proxy
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}

