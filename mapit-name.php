<?php 
/*
 * This function uses the mapit.mysociety.org api to 
 * retrieve boundary data based on postcode
 */
function sc_get_ward_from_postcode($postcode)
{
    //remove spaces and plus signs from the postcode
    $postcode = str_replace(" ", "", $postcode);
    $postcode = str_replace("+", "", $postcode);

    //setup the url
    $url = "http://mapit.mysociety.org/postcode/$postcode";

    //use wordpress function to retrieve results
    $response = wp_remote_get($url);

    //if succesful response then deocde the json and look 
    //for property names with the word "ward" and return 
    //the value of the property.

    if ($response['response']['code'] == 200) {
        $result = json_decode($response['body']);
        $areas = $result->areas;
        if (is_object($areas)) {
            foreach ($areas as $key => $value) {
                $type = $value->type_name;
                if (stristr($type,'ward')) return $value->name;

            }
        }
    }
}

/* This data contains Ordnance Survey data © Crown copyright 
and database right 2010; Royal Mail data © Royal Mail copyright 
and database right 2010 (Code-Point Open); Office for National 
Statistics data © Crown copyright and database right 2010 
(NSPD Open) and © Crown copyright 2004 (Super Output Areas). 
Forked from code by David G Tonge */ ?>
