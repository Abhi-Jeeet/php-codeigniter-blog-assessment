<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index');
$routes->get('post/(:num)', 'HomeController::show/$1');
$routes->post('post/comment', 'HomeController::addComment');

// Blog routes
$routes->get('posts', 'PostController::index');
$routes->get('posts/create', 'PostController::create');
$routes->post('posts/store', 'PostController::store');
$routes->get('posts/edit/(:num)', 'PostController::edit/$1');
$routes->post('posts/update/(:num)', 'PostController::update/$1');
$routes->post('posts/delete/(:num)', 'PostController::delete/$1');

// Blog Post Management Routes
$routes->group('admin', function($routes) {
    $routes->get('blog-posts', 'Admin\BlogPostController::index');
    $routes->get('blog-posts/create', 'Admin\BlogPostController::create');
    $routes->post('blog-posts/store', 'Admin\BlogPostController::store');
    $routes->get('blog-posts/edit/(:num)', 'Admin\BlogPostController::edit/$1');
    $routes->post('blog-posts/update/(:num)', 'Admin\BlogPostController::update/$1');
    $routes->post('blog-posts/delete/(:num)', 'Admin\BlogPostController::delete/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
