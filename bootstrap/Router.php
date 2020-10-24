<?php

namespace Bootstrap;
use App\Classes\Test;

/**
 * Class Router
 * @package Bootstrap
 */
final class Router extends UrlHandler implements RouterInterface
{
    protected $requestMethod;

    protected array $get;
    protected array $post;
    protected array $put;
    protected array $delete;

    public function __construct(String $baseUrl)
    {
        $this->setRequestMethod($_SERVER['REQUEST_METHOD']);
        parent::__construct($baseUrl);
    }

    /**
     * @param mixed $requestMethod
     */
    public function setRequestMethod($requestMethod): void
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * @return mixed
     */
    public function getRequestMethod(): string
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

    protected function getMethodAvailableRoutes(): array
    {
        return $this->{strtolower($this->getRequestMethod())};
    }

    protected function routeHaveParams(Array $route): bool
    {
        return preg_match('/(\{.+})/', $route['route']);
    }

    protected function searchActualRoute(): void
    {
        foreach ($this->getMethodAvailableRoutes() as $route)
            {
                if ($this->routeHaveParams($route)) {
                    $route['route'] = preg_replace('/(\{.+})/', $this->getRouteUrlParam(), $route['route']);
                }

                $isCompatible = (
                    $this->getRouteUrl() == $route['route'] ||
                    $this->getRouteUrl() == $route['route'] . '/'
                ) && substr($route['route'], -1) != '/';

                if ($isCompatible) {
                    $class = 'App\\Classes\\' . $route['callback']['className'];
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
        $this->searchActualRoute();
    }
}