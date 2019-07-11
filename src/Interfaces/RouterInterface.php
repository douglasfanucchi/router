<?php
/**
 * Douglas Fanucchi <douglasfanucchi@gmail.com>
 * Router library to use on my MVC strutcture
 * Repository: https://github.com/douglasfanucchi/router
 */
namespace fanucchi\Router\Interfaces;

interface RouterInterface{
    function get() : bool;
    function post() : bool;
    function put() : bool;
    function delete() : bool;
}