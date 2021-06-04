<?php
// Git hub:
// https://github.com/Zhuk314/dating/commits/main/views/home.html
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

//Start session
session_start();

// Instance Fat-Free
$f3 = Base::instance();

// Define default route for home.html page
$f3->route('GET /', function(){
    // Display the home page
    $view = new Template();
    echo $view->render('views/home.html');

});

// Define route for personal_info.html page
$f3->route('GET|POST /personalInfo', function($f3){
    //Initialize variables for user input
    $fname = "";
    $lname = "";
    $age = "";
    $gender = "";
    $phone = "";

    // If form submitted, add data to session
    // and move user to the next page
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        /*
        // Test var_dump($_POST)
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";
        */

        //Get user input to make form sticky
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];

        // Validate information //
        // is first name valid?
        if(validName($_POST['fname'])){
            // Add name to session
            $_SESSION['fname'] = $_POST['fname'];
        }//Otherwise, set an error variable in the hive
        else {
            $f3->set('errors["fname"]', 'Name is not valid. Must contain only letters.');
        }

        // is last name valid?
        if(validName($_POST['lname'])){
            // Add name to session
            $_SESSION['lname'] = $_POST['lname'];
        }//Otherwise, set an error variable in the hive
        else {
            $f3->set('errors["lname"]', 'Name is not valid. Must contain only letters.');
        }

        // is age valid?
        if(validAge($_POST['age'])){
            // Add age to session
            $_SESSION['age'] = $_POST['age'];
        }//Otherwise, set an error variable in the hive
        else {
            $f3->set('errors["age"]', 'Age is not valid. Must be between 18 and 118');
        }

        // is phone valid?
        if(validPhone($_POST['phone'])){
            // Add age to session
            $_SESSION['phone'] = $_POST['phone'];
        }//Otherwise, set an error variable in the hive
        else {
            $f3->set('errors["phone"]', 'Phone is not valid. Must contain numbers only');
        }

        // Add gender to session with no validation(yet)
        $_SESSION['gender'] = $_POST['gender'];


        // if no errors redirect to profile page
        if (empty($f3->get('errors'))) {
            // Move user to the next page
            header('location: profile');
        }

    }

    //Add the user data to the hive
    $f3->set('fname', $fname);
    $f3->set('lname', $lname);
    $f3->set('age', $age);
    $f3->set('gender', $gender);
    $f3->set('phone', $phone);

    //Display the personal_info.html page
    $view = new Template();
    echo $view->render('views/personal_info.html');
});

// Define route for profile.html page
$f3->route('GET|POST /profile', function($f3){
    //Initialize variables for user input
    $email="";
    $gender="";
    $userState = "";
    $bio = "";

    // If form submitted, add data to session
    // and move user to the next page
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Test var_dump($_POST)
        //var_dump($_POST);

        //Get user input to make form sticky
        $email= $_POST['email'];
        $seeking= $_POST['seeking'];
        $userState = $_POST['state'];
        $bio = $_POST['bio'];


        // Validate Info and add it to session //
        //is email valid
        if(validEmail($email)){
            $_SESSION['email'] = $_POST['email'];
        }else{
            $f3->set('errors["email"]', 'Email is not valid. Must contain \'@\' and \'.\'');
        }

        // Add data to session with no validation
        $_SESSION['state'] = $_POST['state'];
        $_SESSION['seeking'] = $_POST['seeking'];
        $_SESSION['bio'] = $_POST['bio'];

        if (empty($f3->get('errors'))) {
            // Move user to the next page
            header('location: interests');
        }
    }

    //Add the user data to the hive
    $f3->set('email', $email);
    $f3->set('gender', $gender);
    $f3->set('userState', $userState);
    $f3->set('bio', $bio);


    //Get states from the Model and send them to the View
    $f3->set('states', getStates());

    //Display the profile.html page
    $view = new Template();
    echo $view->render('views/profile.html');
});

// Define route for interests.html page
$f3->route('GET|POST /interests', function($f3){
    //Initialize variables for user input
    $userIndoorInterests = array();
    $userOutdoorInterests = array();

    // If form submitted, add data to session
    // and move user to the next page
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        /*
        // Test var_dump($_POST)
        echo '<pre>';
        var_dump($_POST);
        echo '</pre>';
        */

        //Get user input to make form sticky
        $userIndoorInterests = $_POST['indoorInterests'];
        $userOutdoorInterests = $_POST['outdoorInterests'];

        // Validate Info and add it to session //
        // are indoor valid
        if(!empty($userIndoorInterests)) {
            if (validIndoor($userIndoorInterests)) {
                // Add data to session
                $_SESSION['userIndoorInterests'] = $_POST['indoorInterests'];
            } else {
                $f3->set('errors["indoor"]', 'Invalid selection');
            }
        }else{
            $f3->set('errors["indoor"]', 'Invalid selection');
            $userIndoorInterests = array();
        }

        // are outdoor valid
        if(!empty($userOutdoorInterests)) {
            if (validOutdoor($userOutdoorInterests)) {
                // Add data to session
                $_SESSION['userOutdoorInterests'] = $_POST['outdoorInterests'];
            } else {
                $f3->set('errors["outdoor"]', 'Invalid selection');
            }
        }else{
            $f3->set('errors["outdoor"]', 'Invalid selection');
            $userOutdoorInterests = array();
        }

        if (empty($f3->get('errors'))) {
            // Move user to the next page
            header('location: summary');
        }
    }

    //Get the indoor interests from the Model and send them to the View
    $f3->set('indoorInterests', getIndore());
    //Get the outdoor interests from the Model and send them to the View
    $f3->set('outdoorInterests', getOutdoor());

    //Add the user data to the hive
    $f3->set('userIndoorInterests', $userIndoorInterests);
    $f3->set('userOutdoorInterests', $userOutdoorInterests);

    //Display the interests.html page
    $view = new Template();
    echo $view->render('views/interests.html');
});

// Define route for summary.html page
$f3->route('GET|POST /summary', function(){
    //Display the interests.html page
    $view = new Template();
    echo $view->render('views/summary.html');


});

// Run Fat-Free
$f3->run();