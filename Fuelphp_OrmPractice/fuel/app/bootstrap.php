<?php
// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';
//require PKGPATH.'orm/bootstrap.php';

Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
    'DbModel\\Model_DataTrain' => APPPATH.'classes/model/ormpractice.php',//全域類別要加'\\'才抓得到
    //'Orm\\Model' => PKGPATH.'classes/model.php',
));

// Register the autoloader
Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : Fuel::DEVELOPMENT);

// Initialize the framework with the config file.
Fuel::init('config.php');
