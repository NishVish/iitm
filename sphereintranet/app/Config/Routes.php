<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Auth::login');

// Default route
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');

// Auth routes
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

// Dashboard & Registration
$routes->get('home', 'Home::home');
$routes->match(['get', 'post'], 'register', 'Dash::register');

// API
$routes->get('api', 'Api::index');

// User Management
$routes->post('users/addUser', 'Users::addUser');
$routes->post('users/updateProfile', 'Users::updateProfile');
$routes->get('fetch-employee-book', 'Users::fetchUsers');

// HR Module
$routes->get('hr/payslip', 'Hr::payslip');
$routes->get('hr/fetch-user-by-employee-id', 'Users::fetchUserByEmployeeId');
$routes->get('hr/fetch-employee-id-list', 'Users::fetchEmployeeIdList');
$routes->get('hr/employee-details', 'Hr::HrfetchUsers');
$routes->get('hr/system-details', 'Hr::SystemDetails');
$routes->post('hr/update-system-details', 'Hr::updateSystemDetails');

// Announcements
$routes->get('fetch-announcements', 'Announcement::fetchAnnouncements');

// Chat
$routes->get('fetch-chats', 'Chat::fetchChats');
$routes->post('chat/add', 'Chat::add');

// Creative Module
$routes->get('creative', 'CreativeController::index');
$routes->post('creative/upload', 'CreativeController::upload');
$routes->get('creative/fetchDepartmentList', 'CreativeController::fetchDepartmentList');

// 🔹 Event Pages
$routes->get('event_details', 'Event::index');

// 🔹 Data Center / Reports
$routes->get('resource_data_center', 'Database::summaryByState');

// 🔹 Image to Text (OCR API)
$routes->post('imagetotext', 'Tools::convertImageToText');




$routes->get('tools/upload', 'Tools::imageUploadPage');
$routes->post('tools/saveImage', 'Tools::saveImage');


$routes->post('imagetotextfromfile', 'Tools::convertImageToTextFromFile');

// Image Uploading Page
$routes->get('imagetotext/uploadform', 'ImagetoText::uploadForm'); // to display the form
$routes->post('imagetotext/upload', 'ImagetoText::uploadImages');         // to handle uploads

// $routes->post('imagetotext/updatedata/(:num)', 'ImagetoText::updateData/$1');
$routes->get('images/all', 'ImagetoText::allImage');
$routes->get('images/alltable', 'ImagetoText::allImageTable');

$routes->post('imagetotext/updatedata/(:num)', 'ImagetoText::updateData/$1');


$routes->post('websearch', 'Websearch::websearch');
