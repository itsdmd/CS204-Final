<?php

class Router {
    public static $route;
    public static $url;
    public static $found = false;
    public static $param;

    public static function get($route, $function) {
        self::$route = $route;
        if (isset($_GET['url'])) {
            self::$url = $_GET['url'];
        } else {
            self::$url = "";
        }

        if (stripos(self::$route, "{") !== false) {
            $routeArr = explode("/", self::$route);
            $urlArr = explode("/", self::$url);
            self::$param = end($urlArr);
            array_pop($routeArr);
            array_push($routeArr, self::$param);
            self::$route = implode("/", $routeArr);
            self::$url = implode("/", $urlArr);
        }

        if (self::$route == self::$url && $_SERVER['REQUEST_METHOD'] == "GET") {
            self::$found = true;
            $function->__invoke(self::$param);
        }
    }

    public static function post($route, $function) {
        self::$route = $route;
        if (isset($_GET['url'])) {
            self::$url = $_GET['url'];
        } else {
            self::$url = "";
        }

        if (self::$route == self::$url && $_SERVER['REQUEST_METHOD'] == "POST") {
            self::$found = true;
            $function->__invoke();
        }
    }
}
