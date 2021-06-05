<?php
// Git hub:
// https://github.com/Zhuk314/dating-4.git
/*
 * Name: Yurii Zhuk
 * Date: 05/07/2021
 * File Name: index.php
 *
 * This file contains and controls all routing on the dating web site
 */

//Turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//Require autoload file
require_once ('vendor/autoload.php');
require_once ('model/validation.php');
require_once ('model/data-layer.php');
require_once ('classes/member.php');
require_once ('classes/premium_member.php');
require_once ('controller/controller.php');

//Start session
session_start();

// Instantiate classes
$f3 = Base::instance();
$con = new Controller($f3);

// Define default route for home.html page
$f3->route('GET /', function(){
    $GLOBALS['con']->home();
});

// Define route for personal_info.html page
$f3->route('GET|POST /personalInfo', function($f3){
    $GLOBALS['con']->personalInfo();
});

// Define route for profile.html page
$f3->route('GET|POST /profile', function($f3){
    $GLOBALS['con']->profile();
});

// Define route for interests.html page
$f3->route('GET|POST /interests', function($f3){
    $GLOBALS['con']->interests();
});

// Define route for summary.html page
$f3->route('GET|POST /summary', function(){
    $GLOBALS['con']->summary();
});

// Run Fat-Free
$f3->run();