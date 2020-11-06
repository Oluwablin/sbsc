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

    public function numberFactorial(Request $request, $number)
    {
        $factorial = 1;

        for($i= 1; $i<=$number; $i++){
            $factorial = $factorial*$i;
        }

        return response()->json($factorial, 200);
    }
}
