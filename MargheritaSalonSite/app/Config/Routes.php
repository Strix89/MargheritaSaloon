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
$routes->setAutoRoute(false);
 
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
$routes->get('/forgot', 'HomeController::forgot');
$routes->get('/info', 'HomeController::info');
$routes->get('/contacts', 'HomeController::contacts');

$routes->add('/clienterror', 'HomeController::show404');
$routes->add('/userdashboard', 'DashboardController::index');
$routes->add('/logout', 'DashboardController::logout');
$routes->add('/reviews', 'DashboardController::getReviews');
$routes->add('/saloncalendar', "DashboardController::getSalonCalendar");
$routes->add('/personalcalendar', "DashboardController::getPersonalCalendar");

$routes->get('/login', 'HomeController::login');
$routes->get('/signup', 'HomeController::signup');
$routes->get('/forgotpass', 'HomeController::forgot');
$routes->get('/passforgot/(:any)', 'HomeController::resetpswforgot/$1');
$routes->get('/resetpsw', 'DashboardController::resetPsw');
$routes->get('/postannouncements', 'DashboardController::insertAnnounce');
$routes->get('/getannouncements', 'DashboardController::getAnnouncements');
$routes->get('/treatments', 'DashboardController::getTreatements');
$routes->get('/rmtreatments/(:num)', 'DashboardController::rmTreatment/$1');
$routes->get('/addproducts', 'DashboardController::addProducts');
$routes->get('/deleteproduct/(:num)', 'DashboardController::rmProduct/$1');
$routes->get('/products', 'DashboardController::getProducts');
$routes->get('/addworks', "DashboardController::addWorks");
$routes->get('/works', "DashboardController::getWorks");
$routes->get('/deletework/(:num)', 'DashboardController::rmWork/$1');
$routes->get('/makeresdate', "DashboardController::makeReservationDate");
$routes->get('/rmreservation/(:num)/(:any)/(:any)/(:any)', 'dashboardController::removeRes/$1/$2/$3/$4');
$routes->get('/writerev', "DashboardController::writeReview");

$routes->post('/login', 'HomeController::do_login');
$routes->post('/signup', 'HomeController::do_signup');
$routes->post('/forgotpass', 'HomeController::do_forgot');
$routes->post('/passforgot', 'HomeController::do_resetpswforgot');
$routes->post('/resetpsw', 'DashboardController::do_resetPsw');
$routes->post('/postannouncements', 'DashboardController::do_insertAnnounce');
$routes->post('/treatments', 'DashboardController::do_insertTreatment');
$routes->post('/addproducts', 'DashboardController::do_addProducts');
$routes->post('/addworks', "DashboardController::do_addWorks");
$routes->post('/makeresdate', "DashboardController::do_makeReservationDate");
$routes->post('/makeres', "DashboardController::do_makeReservation");
$routes->post('/writerev', "DashboardController::do_writeReview");


$routes->set404Override(function() {
    return view('layouts/clientError', ['title' => "Client Error"]);
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
