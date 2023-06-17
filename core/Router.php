<?php

class Router {
    public static $route;
    public static $url;
    public static $found = false;

    public static function get($route, $function) {
        self::$route = $route;
        if (isset($_GET['url'])) {
            self::$url = $_GET['url'];
        } else {
            self::$url = "";
        }

        if (self::$route == self::$url) {
            self::$found = true;
            $function->__invoke();
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
