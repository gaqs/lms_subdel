<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

service('auth')->routes($routes);

$routes->get('/',                     'Home::index');
$routes->post('/help',                'Home::help');

$routes->get('/blogs',                'Blog::index');
$routes->get('/blogs/show/(:num)',    'Blog::show/$1');

$routes->get('/courses',              'Course::index');
$routes->get('/courses/show/(:num)',  'Course::show/$1');

$routes->post('/comment/create',      'Comment::create');
$routes->post('/comment/update',      'Comment::update');
$routes->get('/comment/delete',       'Comment::delete');

$routes->get('/courses/join',         'Course::join',    ['filter' => 'group:admin,user']);
$routes->get('/lesson/show/(:num)',   'Lesson::show/$1', ['filter' => 'group:admin,user']);

$routes->group('user', ['filter' => 'group:admin,user'], static function($routes){

  $routes->get('/',                   'User::index');
  $routes->post('update',             'User::update'); 
  $routes->get('courses',             'User::courses');
  $routes->get('password',            'User::password');
  $routes->post('change_password',    'User::change_password');
  $routes->get('wishlist',            'User::wishlist');
  $routes->get('user_save_wish',      'User::user_save_wish');

});

$routes->group('admin', ['filter' => 'group:superadmin,admin'], static function($routes){

  $routes->get('/',                  'Admin\Home::index');
  $routes->get('home/delete_media',  'Admin\Home::delete_media');

  //Admin / users
  $routes->get('users',              'Admin\Users::index');
  $routes->get('users/new',          'Admin\Users::new');
  $routes->post('users/create',      'Admin\Users::create');
  $routes->get('users/edit/(:num)',  'Admin\Users::edit/$1');
  $routes->post('users/update',      'Admin\Users::update');
  $routes->post('users/delete',      'Admin\Users::delete');

  //Admin / blogs
  $routes->get('blogs',              'Admin\Blog::index');
  $routes->get('blogs/new',          'Admin\Blog::new');
  $routes->post('blogs/create',      'Admin\Blog::create');
  $routes->get('blogs/edit/(:num)',  'Admin\Blog::edit/$1');
  $routes->post('blogs/update',      'Admin\Blog::update');
  $routes->post('blogs/delete',      'Admin\Blog::delete');

  //Admin / courses
  $routes->get('courses',            'Admin\Course::index');
  $routes->get('courses/new',        'Admin\Course::new');
  $routes->post('courses/create',    'Admin\Course::create');
  $routes->get('courses/edit/(:num)','Admin\Course::edit/$1');
  $routes->post('courses/update',    'Admin\Course::update');
  $routes->post('courses/delete',    'Admin\Course::delete');

  //Admin / modules
  $routes->get('module/new',         'Admin\Module::new');
  $routes->post('module/create',     'Admin\Module::create');
  $routes->get('module/edit/(:num)', 'Admin\Module::edit/$1');
  $routes->post('module/update',     'Admin\Module::update');
  $routes->post('module/delete',     'Admin\Module::delete');

  //Admin / lessons
  $routes->get('lesson/new',         'Admin\Lesson::new');
  $routes->post('lesson/create',     'Admin\Lesson::create');
  $routes->get('lesson/edit/(:num)', 'Admin\Lesson::edit/$1');
  $routes->post('lesson/update',     'Admin\Lesson::update');
  $routes->post('lesson/delete',     'Admin\Lesson::delete');

  //Admin / comments
  $routes->get('comments/',            'Admin\Comment::index');
  $routes->get('comments/edit/(:num)', 'Admin\Comment::edit/$1');
  $routes->post('comments/update',     'Admin\Comment::update');
  $routes->get('comments/delete',     'Admin\Comment::delete');

});







