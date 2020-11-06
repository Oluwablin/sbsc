<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechnicalQuestionsController extends Controller
{
    /*
    |---------------------------------------------
    | GROUPING ANAGRAMS IN AN ARRAY
    |---------------------------------------------
    */
    public function groupAnagram(Request $request) 
    {
        $data = array('ate', 'map', 'eat', 'pat', 'tea' , 'tap');

        foreach($data as $str){
            $strSplit = str_split($str);
            sort($strSplit);
            $strSplit = implode("",$strSplit);
            $group[$strSplit][] = $str; 
        }
        return response()->json($group, 200);
    }

    /*
    |---------------------------------------------
    | FETCH INDEX IN AN ARRAY
    |---------------------------------------------
    */
    public function indexArray(Request $request, $arr, $n) 
    { 
        for($i = 0; $i < $n; $i++) 
        { 
            if($arr[$i] == $i) 
            return $i; 
        } 

        return -1; 
    } 

    /*
    |---------------------------------------------
    | CALCULATE FACTORIAL OF ANY NUMBER
    |---------------------------------------------
    */
    public function numberFactorial(Request $request, $number)
    {
        $factorial = 1;

        for($i= 1; $i<=$number; $i++){
            $factorial = $factorial*$i;
        }

        return $factorial;
    }

    /*
    |---------------------------------------------
    | SORT STATES BY LENGTH IN DESCENDING ORDER
    |---------------------------------------------
    */
    public function sortLengthDescending(Request $request)
    {
        $array = array(
            "Abia",
            "Adamawa",
            "Akwa Ibom",
            "Anambra",
            "Bauchi",
            "Bayelsa",
            "Benue",
            "Borno",
            "Cross River",
            "Delta",
            "Ebonyi",
            "Edo",
            "Ekiti",
            "Enugu",
            "FCT - Abuja",
            "Gombe",
            "Imo",
            "Jigawa",
            "Kaduna",
            "Kano",
            "Katsina",
            "Kebbi",
            "Kogi",
            "Kwara",
            "Lagos",
            "Nasarawa",
            "Niger",
            "Ogun",
            "Ondo",
            "Osun",
            "Oyo",
            "Plateau",
            "Rivers",
            "Sokoto",
            "Taraba",
            "Yobe",
            "Zamfara"
        );

        $array_strlen = array_map('strlen', $array);

        array_multisort($array_strlen, SORT_DESC, SORT_STRING, $array);

        $data = [
            'sorted_states_by_length' => $array,
            'state_at_fifth_position' => $array[5],
        ];
        return response()->json($data, 200);
    }
}
