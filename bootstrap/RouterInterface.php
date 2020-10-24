<?php

namespace OrchRouter;
/**
 * Interface RouterInterface
 * @package OrchRouter
 */
interface RouterInterface {
    public function get(String $route, Array $callback): void;
    public function post(String $route, Array $callback): void;
    public function put(String $route, Array $callback): void;
    public function delete(String $route, Array $callback): void;
}