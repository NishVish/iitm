<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route (landing page)
$routes->get('/', 'Home::index');

// Backend home / admin panel
$routes->get('backend', 'Backend::index');
$routes->get('plan', 'Backend::plan');
$routes->get('backend/sql', 'Backend::sql');
$routes->post('backend/sql/run', 'Backend::runSql');


// ===============================
// Dashboard routes
// ===============================

// Dashboard main page
$routes->get('dashboard', 'Dashboard::index');
$routes->post('dashboard/search', 'Dashboard::search');

// ===============================
// Company management routes
// ===============================

$routes->get('company', 'Company::index');               // Main page
$routes->post('company/getCities', 'Company::getCities');        // AJAX: get cities by state
$routes->post('company/filterCompanies', 'Company::filterCompanies');

$routes->get('company/details/(:any)', 'Company::details/$1');

$routes->post('master/filterCompanies', 'Master::filterCompanies');

$routes->get('company', 'Company::index');

// List all companies
$routes->get('companies', 'Company::index');

// Add new company
// Show add company form
$routes->post('company/add_details', 'Company::add_details');
$routes->get('company/add', 'Company::add'); // Show the form

// Preview form data (POST only)
$routes->post('company/add_check', 'Company::add_check'); 

$routes->post('companies/store', 'Company::store');

// Edit company
$routes->get('companies/edit/(:segment)', 'Company::edit/$1');
$routes->post('companies/update/(:segment)', 'Company::update/$1');

// Delete company (optional)
$routes->post('companies/delete/(:segment)', 'Company::delete/$1');


// Optional: replace existing company if user chooses
$routes->post('company/replace/(:num)', 'Company::replace/$1');

// List page after adding
$routes->get('company/list', 'Company::list');    // Optional: show all companies

$routes->post('company/source_check', 'Company::source_check');


// ===============================
// Leads / Booking routes
// ===============================
$routes->get('leads', 'Leads::index');
$routes->get('leads/view/(:segment)', 'Leads::view/$1');
$routes->post('leads/create', 'Leads::createLead');
$routes->post('leads/store', 'Leads::store');


// ===============================
// Event routes
// ===============================
$routes->get('events', 'Events::index');
$routes->get('events/create', 'Events::create');
$routes->post('events/store', 'Events::store');
$routes->get('events/edit/(:num)', 'Events::edit/$1');
$routes->post('events/update/(:num)', 'Events::update/$1');
$routes->get('events/delete/(:num)', 'Events::delete/$1');


$routes->group('layout-info', function ($routes) {
    $routes->get('/', 'LayoutInfo::index');          // list layouts
    $routes->get('create', 'LayoutInfo::create');    // show create form
    $routes->post('store', 'LayoutInfo::store');     // save layout
});


// ===============================
// Payments routes
// ===============================
$routes->group('exhibitor', function($routes) {

    // Step 1: Instructions (optional companyId)
    $routes->get('instructions/(:any)', 'Exhibitor::instructions/$1'); // Accept company ID
    $routes->get('instructions', 'Exhibitor::instructions'); // fallback if no ID

    // Step 2: Company & Contact Details
    $routes->get('company/(:any)', 'Exhibitor::company/$1');

    // Step 3: Exhibition Details + Price
    $routes->get('exhibition/(:any)', 'Exhibitor::exhibition/$1');

    // POST: Process Payment
    $routes->post('processPayment', 'Exhibitor::processPayment');

});

// ===============================
// Search routes
// ===============================
$routes->get('search', 'Search::index');

// ===============================
// Users routes
// ===============================
$routes->get('users', 'Users::index');
$routes->get('users/add', 'Users::add');
$routes->post('users/store', 'Users::store');
$routes->get('users/edit/(:segment)', 'Users::edit/$1');
$routes->post('users/update/(:segment)', 'Users::update/$1');
$routes->post('users/delete/(:segment)', 'Users::delete/$1');

// ===============================
// Exhibitions routes
// ==
