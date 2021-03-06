<?php

class Validation
{

    // checks to see that a string is all alphabetic and contains more than 1 letter
    static function validName($name)
    {
        return ctype_alpha(trim($name)) && strlen(trim($name)) >= 1;
    }

    // checks to see that an age is numeric and between 18 and 118
    static function validAge($age)
    {
        if ($age >= 18 && $age <= 118) {
            return true;
        } else {
            return false;
        }
    }

    // checks to see that a phone number is valid
    static function validPhone($phone)
    {
        // check does phone contains only numbers
        return is_numeric($phone);
    }

    // checks to see that an email address is valid
    static function validEmail($email)
    {
        // check does email contains "@" and "." symbols
        if (!(strpos($email, "@") == false) &&     // does contain @
            !(strpos($email, ".") == false) &&      // does contain .
            strlen(trim($email)) >= 4) {                 // more than 4 letters
            return true;                                // then true
        } else {
            return false;
        }
    }

    // checks each selected outdoor interest against a list of valid options .
    static function validOutdoor($interests)
    {
        $validInterests = DataLayer::getOutdoor();

        if (empty($interests)) {
            return false;
        }

        // loop through all questions
        foreach ($interests as $userChoice) {
            //if question is not in array of valid questions
            if (!in_array($userChoice, $validInterests)) {
                return false;
            }
        }
        return true;

    }

    // checks each selected indoor interest against a list of valid options.
    static function validIndoor($interests)
    {
        $validInterests = DataLayer::getIndore();

        if (empty($interests)) {
            return false;
        }

        // loop through all questions
        foreach ($interests as $userChoice) {
            //if question is not in array of valid questions
            if (!in_array($userChoice, $validInterests)) {
                return false;
            }
        }
        return true;
    }

}