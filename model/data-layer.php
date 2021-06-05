<?php
class DataLayer
{

    // returns array of states
    static function getStates()
    {
        return array(
            "Alabama",
            "Alaska",
            "Arizona",
            "Arkansas",
            "California",
            "Colorado",
            "Connecticut",
            "Delaware",
            "District Of Columbia",
            "Florida",
            "Georgia",
            "Hawaii",
            "Idaho",
            "Illinois",
            "Indiana",
            "Iowa",
            "Kansas",
            "Kentucky",
            "Louisiana",
            "Maine",
            "Massachusetts",
            "Michigan",
            "Minnesota",
            "Mississippi",
            "Missouri",
            "Montana",
            "Nebraska",
            "Nevada",
            "New Hampshire",
            "New Jersey",
            "New Mexico",
            "New York",
            "North Carolina",
            "North Dakota",
            "Ohio",
            "Oklahoma",
            "Oregon",
            "Pennsylvania",
            "Rhode Island",
            "South Carolina",
            "South Dakota",
            "Tennessee",
            "Texas",
            "Utah",
            "Vermont",
            "Virginia",
            "Washington",
            "West Virginia",
            "Wisconsin",
            "Wyoming",
        );

    }

    // This function will return indoor interests
    static function getIndore()
    {
        return array(
            "tv",
            "puzzles",
            "movies",
            "reading",
            "cooking",
            "playing cards",
            "board games",
            "video games"
        );
    }

    // This function will return outdoor interests
    static function getOutdoor()
    {
        return array(
            "hiking",
            "walking",
            "biking",
            "climbing",
            "swimming",
            "collecting"
        );
    }
}