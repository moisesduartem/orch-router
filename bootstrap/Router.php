<?php

namespace OrchRouter;

/**
 * Class Router
 * @package OrchRouter
 */
final class Router extends UrlHandler implements RouterInterface
{
    private string $requestMethod;

    private string $namespace;

    private array $get;
    private array $post;
    private array $put;
    private array $delete;

    public function __construct(String $baseUrl)
    {
        $this->setRequestMethod($_SERVER['REQUEST_METHOD']);
        parent::__construct($baseUrl);
    }

    public function namespace(string $namespace): void
    {
        $this->setNamespace($namespace);
    }

    /**
     * @param string $namespace
     */
    private function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    private function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param mixed $requestMethod
     */
    private function setRequestMethod($requestMethod): void
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * @return mixed
     */
    private function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    public function get(String $route, Array $callback): void
    {
        $this->get[] = ['route' => $route, 'callback' => $callback];
    }

    public function post(String $route, Array $callback): void
    {
        $this->post[] = ['route' => $route, 'callback' => $callback];
    }

    public function put(String $route, Array $callback): void
    {
        $this->put[] = ['route' => $route, 'callback' => $callback];
    }

    public function delete(String $route, Array $callback): void
    {
        $this->delete[] = ['route' => $route, 'callback' => $callback];
    }

    private function getMethodAvailableRoutes(): array
    {
        return $this->{strtolower($this->getRequestMethod())};
    }

    private function routeHaveParams(array $route): bool
    {
        return preg_match('/(\{.+})/', $route['route']);
    }

    private function find(array $route): bool
    {
        if ($this->routeHaveParams($route)) {
            $route['route'] = preg_replace('/(\{.+})/', $this->getRouteUrlParam(), $route['route']);
        }

        return (
                $this->getRouteUrl() == $route['route'] ||
                $this->getRouteUrl() == $route['route'] . '/'
            ) && substr($route['route'], -1) != '/';
    }

    private function searchActualRoute(): void
    {
        foreach ($this->getMethodAvailableRoutes() as $route)
        {
            if ($this->find($route)) {
                $class = $this->getNamespace() . $route['callback']['className'];
                $instance = new $class();
                $instance->{$route['callback']['method']}(
                    !($this->getRouteUrlParam() != null) ?: $this->getRouteUrlParam()
                );
                return ;
            }
        }
        throw new \Exception("Route doesn't exist.");
    }

    public function run(): void
    {
        try {
            $this->searchActualRoute();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}