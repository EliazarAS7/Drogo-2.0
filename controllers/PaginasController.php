<?php

namespace Controllers;
use MVC\Router;

class PaginasController {
    public static function index( Router $router ) {
        $router->render('paginas/index', [

        ]);
    }
    public static function equipo( Router $router ) {
        $router->render('paginas/equipo', [

        ]);
    }
    public static function preguntasFrecuentes( Router $router ) {
        $router->render('paginas/preguntas-frecuentes', [

        ]);
    }
    public static function servicios( Router $router ) {
        $router->render('paginas/servicios', [

        ]);
    }
    public static function areaAdmin( Router $router ) {
        $router->render('admin/areaPersonalAdmin', [

        ]);
    }
}