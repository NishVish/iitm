<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route (landing page)
// $routes->get('/', 'Home::index');

$routes->get('/', 'Authentication::index');
// $routes->get('/', 'Home::index');
// $routes->get('login', 'Authentication::login');

$routes->post('login', 'Authentication::login');
$routes->get('logout', 'Authentication::logout');
// $routes->get('home', 'Home::index');


$routes->get('user/companyDetails/json', 'User::companyDetails');
$routes->post('user/uploadProfileImage', 'User::uploadProfileImage');



$routes->get('open/qr/(:any)/(:any)', 'Open::openqr/$1/$2');               // Main page
$routes->get('mobile/home', 'Mobile::index');
$routes->get('mobile/profile', 'Mobile::index');
$routes->get('mobile/layout', 'Mobile::index');
$routes->get('mobile/calendar', 'Mobile::index');


$routes->get('mobile/layoutimage/(:any)', 'Events::getlayout/$1');
$routes->get('mobile/test-image', 'Events::testImage');
//Users
// Display all users


// ===============================
// Users routes
// ===============================

$routes->get('user', 'User::index');

// Show form to create a new user
$routes->get('user/create', 'User::create');

// Store a new user
$routes->post('user/store', 'User::store');

// View a single user
$routes->get('user/(:num)', 'User::show/$1');

// Delete a user
$routes->get('user/delete/(:num)', 'User::delete/$1');
$routes->get('user/operation', 'User::operation'); // show editable users
$routes->post('user/operation/save', 'User::saveOperation'); // save edits
$routes->post('users/update/(:segment)', 'Users::update/$1');
$routes->post('user/operation/save/(:num)', 'User::saveOperationById/$1');

// Backend home / admin panel
$routes->get('project_summary', 'Backend::project_summary_main');
$routes->get('kra', 'Backend::kra_main');
$routes->get('profile', 'Backend::profile_main');


$routes->group('backend', function($routes) {
    $routes->get('', 'Backend::index');                   // backend/ → dashboard/home
    $routes->get('plan', 'Backend::plan');               // backend/plan
    $routes->get('sql', 'Backend::sql');                 // backend/sql
    $routes->post('sql', 'Backend::sql');                 // backend/sql
    // $routes->post('sql/run', 'Backend::runSql');         // backend/sql/run
    $routes->get('games', 'Backend::games');             // backend/games
    $routes->get('tv', 'Backend::tv');                   // backend/tv
    $routes->get('project_summary', 'Backend::project_summary'); // backend/project_summary
    $routes->get('profile', 'Backend::profile');         // backend/profile
    $routes->get('kra', 'Backend::kra_main');         // backend/profile
    $routes->get('modulelist', 'Backend::modulelist');         // backend/profile
    
    $routes->get('module/(:any)', 'Backend::module/$1');
    $routes->get('tabledata/(:segment)', 'Backend::spreadsheetview/$1');
    $routes->post('tabledata/update', 'Backend::updateCell');
    $routes->post('tabledata/add', 'Backend::addRow');
    $routes->post('tabledata/delete', 'Backend::deleteRow');
});

// ===============================
// Dashboard routes
// ===============================

// Dashboard main page
$routes->get('dashboard', 'Dashboard::index');
$routes->post('dashboard/search', 'Dashboard::search');

// ===============================
// Company management routes
// ===============================
$routes->post('company/getDynamicFilters', 'Company::getDynamicFilters');

$routes->get('company/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Company::byvar/$1/$2/$3/$4/$5/$6/$7/$8');
$routes->get('company/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Company::byvar/$1/$2/$3/$4/$5/$6/$7');
$routes->get('company/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Company::byvar/$1/$2/$3/$4/$5/$6');
$routes->get('company/(:any)/(:any)/(:any)/(:any)/(:any)', 'Company::byvar/$1/$2/$3/$4/$5');
$routes->get('company/(:any)/(:any)/(:any)/(:any)', 'Company::byvar/$1/$2/$3/$4');
$routes->get('company/(:any)/(:any)/(:any)', 'Company::byvar/$1/$2/$3');
$routes->get('company/(:any)/(:any)', 'Company::byvar/$1/$2');
$routes->get('company/(:any)', 'Company::byvar/$1');




$routes->get('company/details/(:any)/(:any)', 'Company::details/$1/$2');

$routes->post('master/filterCompanies', 'Master::filterCompanies');
// $routes->get('company/bystate/(:any)', 'Company::getCompanySourcesContactsByState/$1');
// Route for spreadsheet AJAX updates
$routes->post('company/update_cell', 'Company::update_cell');
$routes->post('company/compare_popup', 'Company::compare_popup');

// Show add company form
$routes->post('company/add_details', 'Company::add_details');

$routes->get('company/add', 'Company::add'); // Show the form
$routes->get('company/addexhibitor', 'Company::addexhibitor'); // Show the form

// Preview form data (POST only)
$routes->post('company/add_check', 'Company::add_check'); 

$routes->post('company/store', 'Company::store');

// Delete company (optional)
$routes->post('company/delete/(:segment)', 'Company::delete/$1');

// Optional: replace existing company if user chooses
$routes->post('company/replace/(:num)', 'Company::replace/$1');

$routes->get('company/operation', 'Company::opreation');

$routes->get('company/filter', 'Company::filter');



// Standard base route
$routes->get('database', 'Database::index');

// Clean state route (database/delhi, database/west-bengal)
$routes->get('database/(:any)', 'Database::index/$1');
// // Grouped
// $routes->group('database', function($routes) {

//     // Main page
//     $routes->get('/', 'Database::index');
// // 1. Base URL: domain.com/database (Shows All)

// // 2. Clean State URL: domain.com/database/Delhi (Shows Specific State)
// $routes->get('database/(:any)', 'Database::index/$1');
// });




$routes->group('database/company', function($routes) {

    // Main page
    $routes->get('/', 'Company::index');
    // AJAX
    $routes->post('getCities', 'Company::getCities');
    $routes->post('filterCompanies', 'Company::filterCompanies');
    $routes->post('compare_popup', 'Company::compare_popup');
    $routes->post('source_check', 'Company::source_check');

    // Details
    $routes->get('details/(:any)', 'Company::details/$1');

    // Add company
    $routes->get('add', 'Company::add');
    $routes->post('add_details', 'Company::add_details');
    $routes->post('add_check', 'Company::add_check');
    $routes->post('store', 'Company::store');

    // Dummy
    $routes->get('dummy', 'Company::dummyData');

    // Edit / Update
    $routes->get('edit/(:segment)', 'Company::edit/$1');
    $routes->post('update/(:segment)', 'Company::update/$1');

    // Delete
    $routes->post('delete/(:segment)', 'Company::delete/$1');

    // Replace
    $routes->post('replace/(:num)', 'Company::replace/$1');

    // List & Stats
    $routes->get('list', 'Company::list');
    $routes->get('stats', 'Company::stats');

});



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
$routes->get('lead/createQuick/(:any)', 'Leads::createQuicklead/$1');
$routes->post('leads/store', 'Leads::store');
$routes->post('leads/clear', 'Leads::clearLeads');
$routes->get('leads/add-random', 'Leads::addRandomLead');

$routes->post('discussion/add', 'Leads::add');


// ===============================
// Event routes
// ===============================
$routes->get('events', 'Events::index');
$routes->get('events/create', 'Events::create');
$routes->post('events/store', 'Events::store');
$routes->get('events/edit/(:num)', 'Events::edit/$1');
$routes->post('events/update/(:num)', 'Events::update/$1');
$routes->get('events/delete', 'Events::delete');
$routes->get('events/fetch/iitm', 'Events::fetchiitmdate');
$routes->get('events/upcoming', 'Events::upcoming');
$routes->get('events/upcoming/(:any)', 'Events::upcoming/$1');

$routes->post('events/update-cell', 'Events::updateCell');



$routes->group('layout-info', function ($routes) {
    $routes->get('/', 'LayoutInfo::index');          // list layouts
    $routes->get('create', 'LayoutInfo::create');    // show create form
    $routes->post('store', 'LayoutInfo::store');     // save layout
});
// Negotiation asking for 5000 Less if Booked for 3 Location

// ===============================
// Payments routes
// ===============================
$routes->group('booking', function($routes) {

    // Step 1
    // $routes->get('instructions', 'Exhibitor::instructions');
$routes->get('instructions/(:segment)', 'Booking::instructions/$1');

    // Step 2
    $routes->get('company/(:segment)', 'Booking::company/$1');

$routes->post('updatefrombooking/(:segment)', 'Booking::update/$1');

    // $routes->get('company/(:num)', 'Exhibitor::company/$1');

    // Step 3
    // $routes->get('exhibition/(:num)', 'Exhibitor::exhibition/$1');
    $routes->get('booking_details/(:segment)', 'Booking::booking_details/$1');

    // Payment
    $routes->post('savebookingdetails/(:segment)', 'Booking::savebookingdetails/$1');


    $routes->get('summary/(:num)', 'Booking::summary/$1');

    $routes->get('view', 'Booking::public_view');           // GET: show the form
    $routes->post('view', 'Booking::show_booking_details'); // POST: process the form
});



    // // ===============================
    // // Exhibitor Booking
    // // ===============================
    // $routes->get('exhibitor_booking', 'Booking::exhibitor_bookinginstructions');
    // $routes->get('exhibitor_booking/stallinfo', 'Booking::stallinfo');
    // $routes->get('exhibitor_booking/details', 'Booking::exhibitor_details');
// <a href="<?= site_url('booking/exhibitor_booking/stallinfo') 




// ===============================
// Search routes
// ===============================
$routes->get('search', 'Search::index');




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
    // $routes->get('clear-companies', 'DatabaseOperation::clearCompanyTables');
    $routes->get('clear-companies/(:any)', 'DatabaseOperation::clearCompanyTables/$1');

    // High risk
    $routes->get('clear-non-financial', 'DatabaseOperation::clearAllNonFinancial');

    // EXTREME (comment this in production)
     $routes->get('wipe-all', 'DatabaseOperation::clearEverything');
// });

$routes->get('tools', 'Tools::index');               // Main page
$routes->get('tools/network', 'Tools::server');               // Main page
$routes->post('tools/upload', 'Tools::webscraper');
$routes->get('tools/webscraper', 'Webscraper::index');

// $routes->get('tools', 'Tools::index');               // Main page
$routes->get('tools/listFiles', 'Tools::listFiles');
$routes->get('tools/download/(:any)', 'Tools::download/$1');


$routes->get('tools/ftp', 'Tools::ftp');               // Main page

$routes->get('tools/download-server', 'Tools::downloadServer');




$routes->group('ticket', function($routes) {
    $routes->get('/', 'Ticket::index');
    $routes->post('store', 'Ticket::store');
        $routes->post('storeajax', 'Ticket::storeajax');

    $routes->post('update/(:num)', 'Ticket::update/$1');

    // Dynamic type route
    $routes->get('type/(:segment)', 'Ticket::type/$1');
    // $routes->get('view/(:segment)', 'Ticket::view/$1');
});


$routes->group('registration', function($routes) {
    $routes->get('/', 'Registration::index');
    $routes->get('publicformtv/(:any)', 'Registration::publicformtradevisitor/$1');// multi
    $routes->get('publicformex', 'Registration::publicformexhibitor'); //specific
    $routes->get('publicformspot', 'Registration::publicformspot');//multi
// Routes.php
// $routes->get('regitersuccess/exhibitor', 'Registration::thankyouexhibitor');

// ✅ Route needs two (:segment) for both $data and $number
$routes->get('regitersuccess/(:segment)/(:segment)', 'Registration::regitersuccess/$1/$2');


$routes->get('generatebadge/(:any)', 'Registration::generatebadge/$1');
    $routes->get('spotinterface', 'Registration::getgataforprint');

    $routes->get('spotinterface/(:any)/(:any)', 'Registration::getgataforprint/$1/$2');
    // $routes->get('searchentry', 'Registration::searchentry');
$routes->post('searchentry/(:segment)', 'Registration::searchentry/$1');
$routes->get('searchentry/(:segment)', 'Registration::searchentry/$1');

$routes->get('view/(:segment)', 'Registration::registrationview/$1');
    // $routes->get('spotform', 'Registration::spotform');
    // $routes->get('spotinterface', 'Registration::spotinterface');
    // $routes->get('spot', 'Registration::publicformtradevisitor');

 // $routes->get('publicform', 'Registration::publicform');
    // $routes->post('update/(:num)', 'Issue::update/$1');
});

