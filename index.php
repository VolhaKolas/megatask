<?php
use Core\Database;
use Core\Request;
use Core\Router;

session_start();

function __autoload($class_name)
{
    $class_name = str_replace("\\", "/", $class_name);
    require_once($class_name . '.php');
}

$router = new Router();
$router->run('routes')
    ->path(Request::url());

$roles = new \Core\Roles();
$roles->roles();

$courses = new  \Core\Course();
$courses->course();

$categories = new \Core\Category();
$categories->category();
$categories->subcategory();

