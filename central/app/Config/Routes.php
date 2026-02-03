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

// Add new company
// Show add company form
$routes->post('company/add_details', 'Company::add_details');
$routes->get('company/add', 'Company::add'); // Show the form

// Preview form data (POST only)
$routes->post('company/add_check', 'Company::add_check'); 

$routes->post('company/store', 'Company::store');

// Edit company
$routes->get('company/edit/(:segment)', 'Company::edit/$1');
$routes->post('company/update/(:segment)', 'Company::update/$1');

// Delete company (optional)
$routes->post('company/delete/(:segment)', 'Company::delete/$1');


// Optional: replace existing company if user chooses
$routes->post('company/replace/(:num)', 'Company::replace/$1');

// List page after adding
$routes->get('company/list', 'Company::list');    // Optional: show all companies

$routes->post('company/source_check', 'Company::source_check');

// $routes->post('update/(:segment)', 'Company::update/$1');


// Show the add contact form
$routes->get('contacts/add/(:any)', 'Contacts::add/$1'); 
// (:any) is for company_id

// Handle the form submission
$routes->post('contacts/savePerson', 'Company::savePerson');


// ===============================
// Leads / Booking routes
// ===============================
$routes->get('leads', 'Leads::index');
$routes->get('lead/details/(:any)', 'Leads::details/$1');
// $routes->get('leads/view/(:segment)', 'Leads::view/$1');
$routes->post('leads/create', 'Leads::createLead');
$routes->post('leads/store', 'Leads::store');
$routes->post('discussion/add', 'Leads::add');


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
// Negotiation asking for 5000 Less if Booked for 3 Location

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
// Crossvalidation routes
// ===============================
// Show the crossvalidation index page
$routes->get('crossvalidation', 'CrossValidation::index');

// Run the batch cross-validation
$routes->get('crossvalidation/crossValidate', 'CrossValidation::companyCrossValidation');
$routes->get('crossvalidation/crossValidateContact', 'CrossValidation::contactCrossValidation');
$routes->get('crossvalidation/clear', 'CrossValidation::clearMatches');
$routes->get('crossvalidation/clearcontact', 'CrossValidation::clearMatchesContact');

// Optional: handle overwrite/merge actions
$routes->post('crossvalidation/action', 'CrossValidation::handleAction');
$routes->post('crossvalidation/actioncontact', 'CrossValidation::handleAction');



// $routes->group('db', ['filter' => 'auth'], function ($routes) {

    // Safe
    $routes->get('clear-matching', 'DatabaseOperation::clearMatchingTables');

    // Medium risk
    $routes->get('clear-contacts', 'DatabaseOperation::clearContactTables');
    $routes->get('clear-companies', 'DatabaseOperation::clearCompanyTables');

    // High risk
    $routes->get('clear-non-financial', 'DatabaseOperation::clearAllNonFinancial');

    // EXTREME (comment this in production)
     $routes->get('wipe-all', 'DatabaseOperation::clearEverything');
// });
