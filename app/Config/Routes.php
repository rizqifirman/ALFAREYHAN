<?php

use CodeIgniter\Router\RouteCollection;

// Rute untuk Login & Logout
$routes->get('/login', 'Login::index');
$routes->post('/login/auth', 'Login::auth');
$routes->get('/logout', 'Login::logout');

// Rute Utama (Dashboard) - Diproteksi oleh filter 'auth'
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/products', 'Products::index', ['filter' => 'auth']);
$routes->post('/products/store', 'Products::store', ['filter' => 'auth']);
// Rute Hapus (Menerima ID sebagai parameter)
$routes->get('/products/delete/(:num)', 'Products::delete/$1', ['filter' => 'auth']);
$routes->post('/products/update', 'Products::update', ['filter' => 'auth']);
// RUTES MATERIAL
$routes->get('/materials', 'Materials::index', ['filter' => 'auth']);
$routes->post('/materials/store', 'Materials::store', ['filter' => 'auth']);
$routes->post('/materials/update', 'Materials::update', ['filter' => 'auth']);
$routes->get('/materials/delete/(:num)', 'Materials::delete/$1', ['filter' => 'auth']);
// Rute Export
$routes->get('/products/export/excel', 'Products::exportExcel', ['filter' => 'auth']);
$routes->get('/products/export/csv', 'Products::exportCsv', ['filter' => 'auth']);
// Rute Export Material
$routes->get('/materials/export/excel', 'Materials::exportExcel', ['filter' => 'auth']);
$routes->get('/materials/export/csv', 'Materials::exportCsv', ['filter' => 'auth']);
// Rute Import
$routes->post('/materials/import', 'Materials::importCsv', ['filter' => 'auth']);
$routes->post('/products/import', 'Products::importCsv', ['filter' => 'auth']);
// Rute Workers / Tukang
$routes->get('/workers', 'Workers::index', ['filter' => 'auth']);
$routes->post('/workers/store', 'Workers::store', ['filter' => 'auth']);
$routes->post('/workers/update', 'Workers::update', ['filter' => 'auth']);
$routes->get('/workers/delete/(:num)', 'Workers::delete/$1', ['filter' => 'auth']);
$routes->get('/workers/export/excel', 'Workers::exportExcel', ['filter' => 'auth']);
$routes->get('/workers/export/csv', 'Workers::exportCsv', ['filter' => 'auth']);
// Rute Ongkos Jahit
$routes->get('/ongkos', 'Ongkos::index', ['filter' => 'auth']);
$routes->post('/ongkos/store', 'Ongkos::store', ['filter' => 'auth']);
$routes->post('/ongkos/update', 'Ongkos::update', ['filter' => 'auth']);
$routes->get('/ongkos/delete/(:num)', 'Ongkos::delete/$1', ['filter' => 'auth']);
$routes->get('/ongkos/export/excel', 'Ongkos::exportExcel', ['filter' => 'auth']);
$routes->get('/ongkos/print', 'Ongkos::print', ['filter' => 'auth']);