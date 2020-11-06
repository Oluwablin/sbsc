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
    public function groupAnagram() 
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
}
