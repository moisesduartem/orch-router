<?php

namespace Bootstrap;
/**
 * Interface RouterInterface
 * @package Bootstrap
 */
interface RouterInterface {
    public function get(String $route, Array $callback): void;
    public function post(String $route, Array $callback): void;
    public function put(String $route, Array $callback): void;
    public function delete(String $route, Array $callback): void;
}