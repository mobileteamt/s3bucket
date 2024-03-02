<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Welcome'; // Default controller and method

// Custom routes
$route['image/index'] = 'ImageController/index'; // Route for uploading images
$route['image/upload'] = 'ImageController/upload'; // Route for uploading images
$route['image/view'] = 'ImageController/view'; // Route for viewing images

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
