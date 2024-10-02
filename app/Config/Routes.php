<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

service('auth')->routes($routes);

$routes->get('/', 'Home::index');

$routes->get('/blogs',              'Blog::index');
$routes->get('/blogs/show/(:num)',  'Blog::show/$1');

//Admin / users
$routes->get('/admin/users',                'Admin\Users::index');

$routes->get('/admin/users/new',            'Admin\Users::new');
$routes->post('/admin/users/create',        'Admin\Users::create');

$routes->get('/admin/users/edit/(:num)',    'Admin\Users::edit/$1');
$routes->post('/admin/users/update',        'Admin\Users::update');

$routes->post('/admin/users/delete',        'Admin\Users::delete');

//Admin / blogs
$routes->get('/admin/blogs',                'Admin\Blog::index');

$routes->get('/admin/blogs/new',            'Admin\Blog::new');
$routes->post('/admin/blogs/create',        'Admin\Blog::create');

$routes->get('/admin/blogs/edit/(:num)',    'Admin\Blog::edit/$1');
$routes->post('/admin/blogs/update',        'Admin\Blog::update');

$routes->post('/admin/blogs/delete',        'Admin\Blog::delete');

$routes->get('/admin/blogs/delete_file',    'Admin\Blog::delete_file');
$routes->get('/admin/blogs/delete_image',   'Admin\Blog::delete_image');

//Admin / courses
$routes->get('/admin/courses',                'Admin\Course::index');

$routes->get('/admin/courses/new',            'Admin\Course::new');
$routes->post('/admin/courses/create',        'Admin\Course::create');

$routes->get('/admin/courses/edit/(:num)',    'Admin\Course::edit/$1');
$routes->post('/admin/courses/update',        'Admin\Course::update');

$routes->post('/admin/courses/delete',        'Admin\Course::delete');

//Admin / modules
$routes->get('/admin/module/new',            'Admin\Module::new');
$routes->post('/admin/module/create',        'Admin\Module::create');

$routes->get('/admin/module/edit/(:num)',    'Admin\Module::edit/$1');
$routes->post('/admin/module/update',        'Admin\Module::update');

$routes->post('/admin/module/delete',        'Admin\Module::delete');

//Admin / lessons
$routes->get('/admin/lesson/new',            'Admin\Lesson::new');
$routes->post('/admin/lesson/create',        'Admin\Lesson::create');

$routes->get('/admin/lesson/edit/(:num)',    'Admin\Lesson::edit/$1');
$routes->post('/admin/lesson/update',        'Admin\Lesson::update');

$routes->post('/admin/lesson/delete',        'Admin\Lesson::delete');




