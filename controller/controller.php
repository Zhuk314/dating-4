<?php

class Controller
{
    private $_f3; //router

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        //Display the home page
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function personalInfo()
    {
        //Reinitialize session array
        $_SESSION = array();

        //Initialize variables for user input
        $fname = "";
        $lname = "";
        $age = "";
        $gender = "";
        $phone = "";
        $premium = "";

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
            $premium = $_POST['premium'];

            // Instantiate the appropriate class(Member or PremiumMember)
            // depending on whether or not the checkbox $premium was selected.
            // then, add premium 'y' to session if selected, if not, add 'n'
            if($premium == 'y'){
                $_SESSION['member'] = new PremiumMember(); //create a new premium member class
            } else{
                $_SESSION['member'] = new Member(); //create a new member class
                $premium = 'n';
            }

            // Validate Information //
            // is first name valid?
            if(Validation::validName($_POST['fname'])){
                // Add name to session
                $_SESSION['member']->setFname($fname);
            }//Otherwise, set an error variable in the hive
            else {
                $this->_f3->set('errors["fname"]', 'Name is not valid. Must contain only letters.');
            }

            // is last name valid?
            if(Validation::validName($_POST['lname'])){
                // Add name to session
                $_SESSION['member']->setLname($lname);
            }//Otherwise, set an error variable in the hive
            else {
                $this->_f3->set('errors["lname"]', 'Name is not valid. Must contain only letters.');
            }

            // is age valid?
            if(Validation::validAge($_POST['age'])){
                // Add age to session
                $_SESSION['member']->setAge(intval($age));
            }//Otherwise, set an error variable in the hive
            else {
                $this->_f3->set('errors["age"]', 'Age is not valid. Must be between 18 and 118');
            }

            // is phone valid?
            if(Validation::validPhone($_POST['phone'])){
                // Add age to session
                $_SESSION['member']->setPhone($phone);
            }//Otherwise, set an error variable in the hive
            else {
                $this->_f3->set('errors["phone"]', 'Phone is not valid. Must contain numbers only');
            }

            // Add gender to session with no validation(yet)
            if($gender == 'male' || $gender == 'female'){
                $_SESSION['member']->setGender($gender);
            }
            else {
                $this->_f3->set('errors["gender"]', 'Please, select gender');
            }

            // if no errors redirect to profile page
            if (empty($this->_f3->get('errors'))) {
                // Move user to the next page
                header('location: profile');
            }

            /*
            echo "<pre>";
            var_dump($_SESSION);
            echo "</pre>";
            */
        }

        //Add the user data to the hive
        $this->_f3->set('fname', $fname);
        $this->_f3->set('lname', $lname);
        $this->_f3->set('age', $age);
        $this->_f3->set('gender', $gender);
        $this->_f3->set('phone', $phone);
        $this->_f3->set('premium', $premium);

        //Display the personal_info.html page
        $view = new Template();
        echo $view->render('views/personal_info.html');
    }

    function profile()
    {
        //Initialize variables for user input
        $email="";
        $seeking="";
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
            if(Validation::validEmail($email)){
                $_SESSION['member']->setEmail($email);
            }else{
                $this->_f3->set('errors["email"]', 'Email is not valid. Must contain \'@\' and \'.\'');
            }

            // Add Seeking to session if value is correct
            if($seeking == 'male' || $seeking == 'female'){
                $_SESSION['member']->setSeeking($seeking);
            }
            else {
                $this->_f3->set('errors["seeking"]', 'Please, select seeking');
            }

            if (empty($this->_f3->get('errors'))) {
                // Add data to session with no validation if no errors previously
                $_SESSION['member']->setState($userState);
                $_SESSION['member']->setBio($bio);


                // Move user to the interests page if premium
                if ($_SESSION['member'] instanceof PremiumMember) {
                    header('location: interests');
                }
                // otherwise directly to summary
                else{
                    header('location: summary');
                }
            }
        }

        //Add the user data to the hive
        $this->_f3->set('email', $email);
        $this->_f3->set('seeking', $seeking);
        $this->_f3->set('userState', $userState);
        $this->_f3->set('bio', $bio);


        //Get states from the Model and send them to the View
        $this->_f3->set('states', DataLayer::getStates());

        //Display the profile.html page
        $view = new Template();
        echo $view->render('views/profile.html');
    }

    function interests()
    {
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
                if (Validation::validIndoor($userIndoorInterests)) {
                    // Add data to session
                    $_SESSION['member']->setInDoorInterests($userIndoorInterests);
                } else {
                    $this->_f3->set('errors["indoor"]', 'Invalid selection');
                }
            }else{
                $this->_f3->set('errors["indoor"]', 'Invalid selection');
                $userIndoorInterests = array();
            }

            // are outdoor valid
            if(!empty($userOutdoorInterests)) {
                if (Validation::validOutdoor($userOutdoorInterests)) {
                    // Add data to session
                    $_SESSION['member']->setOutDoorInterests($userOutdoorInterests);
                } else {
                    $this->_f3->set('errors["outdoor"]', 'Invalid selection');
                }
            }else{
                $this->_f3->set('errors["outdoor"]', 'Invalid selection');
                $userOutdoorInterests = array();
            }

            if (empty($this->_f3->get('errors'))) {
                // Move user to the next page
                header('location: summary');
            }

        }

        //Get the indoor interests from the Model and send them to the View
        $this->_f3->set('indoorInterests', DataLayer::getIndore());
        //Get the outdoor interests from the Model and send them to the View
        $this->_f3->set('outdoorInterests', DataLayer::getOutdoor());

        //Add the user data to the hive
        $this->_f3->set('userIndoorInterests', $userIndoorInterests);
        $this->_f3->set('userOutdoorInterests', $userOutdoorInterests);

        //Display the interests.html page
        $view = new Template();
        echo $view->render('views/interests.html');
    }

    function summary()
    {
        //Display the summary.html page
        $view = new Template();
        echo $view->render('views/summary.html');

        /*
        echo "<pre>";
        var_dump($_SESSION);
        echo "</pre>";
        */
    }
}