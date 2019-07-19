<?php
/**
 * Douglas Fanucchi <douglasfanucchi@gmail.com>
 * Router library to use on my MVC strutcture
 * Repository: https://github.com/douglasfanucchi/router
 */
namespace fanucchi\Router\Interfaces;

interface RouterInterface{
    function get(String $route, String $controllerAction) : bool;
    function post(String $route, String $controllerAction) : bool;
    function put(String $route, String $controllerAction) : bool;
    function delete(String $route, String $controllerAction) : bool;
}