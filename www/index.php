<?php

require 'vendor/autoload.php';

spl_autoload_register('myAutoloader');

function myAutoloader($class)
{

    // Tentatitve d'instance de App\Core\View
    // App\Core\View -> App/Core/View
    $class = str_replace("\\", "/", $class);
    // App/Core/View -> Core/View
    $class = str_ireplace("App/", "src/", $class);
    // Core/View -> Core/View.php
    $class .= ".php";

    if (file_exists($class)) {
        include $class;
    }
}

$uri = $_SERVER["REQUEST_URI"];
// var_dump($uri);

$listOfRoutes = yaml_parse_file("routes.yml");
// echo '<pre>';
// var_dump($listOfRoutes[$uri]);
// echo '</pre>';
// $selectedRoute = $listOfRoutes['/404'];

if (isset($listOfRoutes[$uri])) {
    $selectedRoute = $listOfRoutes[$uri];
    // echo '<pre>';
    // var_dump($selectedRoute);
    // echo '</pre>';
}

$controller = $selectedRoute['controller'];
$action = $selectedRoute['action'];

if (file_exists("src/Controllers/" . $controller . ".php")) {
    include "src/Controllers/" . $controller . ".php";


    //Est-ce que la class existe
    $controllerWithNP = "App\\Controllers\\" . $controller;

    if (class_exists($controllerWithNP)) {
        $cObject = new $controllerWithNP();
        //Est-ce que la méthode existe 
        if (method_exists($cObject, $action)) {

            if (isset($param)) {
                $cObject->$action($param);
            } else {
                $cObject->$action();
            }
        } else {
            die("La methode " . $action . " n'existe pas");
        }
    } else {
        die("La class " . $controllerWithNP . " n'existe pas");
    }
} else {
    die("Le fichier Controllers/" . $controller . ".php n'existe pas");
}
