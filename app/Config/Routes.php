<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', ['namespace' => 'App\api\v1'], static function ($routes) {
    $routes->post('coasters', 'Coaster::store');
    $routes->put('coasters/(:num)', 'Coaster::update/$1');

    $routes->group('coasters/(:num)/wagons', static function ($routes) {
        $routes->post('', 'Wagon::store/$1');
        $routes->delete('(:num)', 'Wagon::destroy/$1/$2');
    });
});
