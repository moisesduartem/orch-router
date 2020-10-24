<?php

namespace OrchRouter;

/**
 * Class UrlHandler
 * @package OrchRouter
 */
abstract class UrlHandler
{
    protected string $baseUrl;
    protected string $actualUrl;
    protected string $routeUrl;

    public function __construct(string $baseUrl)
    {
        $this->setBaseUrl($baseUrl);
        $this->setActualUrl(explode('?', $_SERVER['REQUEST_URI'], 2)[0]);
        $this->catchRouteUrl();
    }

    public function catchRouteUrl(): void
    {
        $this->setRouteUrl(str_replace($this->getBaseUrl(), '',$this->getActualUrl()));
    }

    /**
     * @param String $baseUrl
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return String
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param String $actualUrl
     */
    public function setActualUrl(string $actualUrl): void
    {
        $this->actualUrl = $actualUrl;
    }

    /**
     * @return String
     */
    public function getActualUrl(): string
    {
        return $this->actualUrl;
    }

    /**
     * @param String $routeUrl
     */
    public function setRouteUrl(string $routeUrl): void
    {
        $this->routeUrl = $routeUrl;
    }

    /**
     * @return String
     */
    public function getRouteUrl(): string
    {
        return $this->routeUrl;
    }

    protected function getRouteUrlParam(): string
    {
        $array = explode('/', $this->getRouteUrl());
        return end($array);
    }
}