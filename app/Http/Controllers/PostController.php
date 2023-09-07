<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{

    public function postRequest (Request $request)
    {
        $first_number = $request->input('x');
        $second_number = $request->input('y');
        $string = $request->input('operation_type');
        $op = "Operation";

        // $string = str_replace('.',"",$string);
        // $string = str_replace(',',"",$string);
        // $string = str_replace('!',"",$string);
        // $string = str_replace('?',"",$string);
        // $string = str_replace(';',"",$string);
        // $string = str_replace(':',"",$string);
        // $string = str_replace('"',"",$string);
        // $strin                               
        
        $arrA = explode(' ',$string);
        $arr = array_map('strtolower', $arrA);
        
        $num_arr = array(); $num_index = array();
        $operator = '';
        $f_word_index = 0; $word_index = 0;
        
        for ($i=0; $i < count($arr); $i++) { 
            if (is_numeric($arr[$i])) {
                    array_push($num_arr,$arr[$i]);
                    array_push($num_index,$i);
                if(array_key_exists(1, $num_index) && ($arr[$i-1]=='-') && is_numeric($arr[$i-2])){ //special case of dash (-)
                    $operator = '-';
                    $word_index = $i;
                }
                if(array_key_exists(1, $num_index) && ($arr[$i-1]=='x') && is_numeric($arr[$i-2])){ //special case of times (x)
                    $operator = '*';
                    $word_index = $i;
                }
            }
            if ($arr[$i] == 'from'){
                $f_word_index = $i;
            }

            if (in_array($arr[$i], ['multiply','multiplication','product','times','*','exponentially','accumulate','proliferate','mount','expand','spread','mushroom','snowball','numerous','burgeon','wax'], true ) ) {
                $operator = '*';
                $word_index = $i;
            }
            else if (in_array($arr[$i], ['add','plus','more','increase','combined','grow','addition','sum','all','altogether','total','together','increase','increased','count','compute','calculate','enumerate','reckon','tally','+'], true ) || $arr[$i]=='many'&&$arr[$i-1]=='how' || $arr[$i]=='figure'&&$arr[$i-1]=='up'||$arr[$i]=='more'&&$arr[$i-1]=='than') {
                $operator = '+';
                $word_index = $i;
            }
            else if (in_array($arr[$i], ['subtract','minus','difference','left','subtraction','remove','reduce','deduce','decrease','diminute','diminish','take','deduct','debit','abstract','discount','withdraw','dock','off','comot'], true ) || $arr[$i]=='than'&&$arr[$i-1]=='less' || $arr[$i]=='than'&&$arr[$i-1]=='fewer'||$arr[$i]=='away'&&$arr[$i-1]=='take') {
                $operator = '-';
                $word_index = $i;
            }
        }

        if((in_array("first", $arr) || in_array("x", $arr)) || (in_array("second", $arr) || in_array("y", $arr))){
            ( in_array("first", $arr) ? $first_index = array_search('first', $arr) : $first_index = 9999999 );
            ( in_array("x", $arr) ? $x_index = array_search('x', $arr) : $x_index = 9999999 );
            ( in_array("second", $arr) ? $second_index = array_search('second', $arr) : $second_index = 9999999 );
            ( in_array("y", $arr) ? $y_index = array_search('y', $arr) : $y_index = 9999999 );
            
            if(count($num_arr)==0){ //x from y
                if((($first_index < $f_word_index) && ($f_word_index < $second_index))  || (($x_index < $f_word_index) && ($f_word_index < $y_index))){
                    $temp_number = $first_number;
                    $first_number = $second_number; 
                    $second_number = $temp_number;
                }
            }
            else if(count($num_arr) == 1){
                if($first_index != 9999999 || $x_index != 9999999){
                    if(($f_word_index > $num_index[0]) && ($first_index > $f_word_index) || ($f_word_index < $first_index) && ( $first_index > $num_index[0])){ //y-num,f<first<num
                        $second_number = array_pop($num_arr);
                    }else if(($f_word_index < $num_index[0]) && ($first_index < $f_word_index) || ($f_word_index < $num_index[0]) && ( $num_index[0] < $first_index )){
                        $second_number = $first_number; //$temp_number;
                        $first_number = array_pop($num_arr);
                    }
                }else if ($second_index != 9999999 || $y_index != 9999999){
                    if(($f_word_index > $num_index[0]) && ($second_index > $f_word_index) || ($f_word_index < $second_index) && ( $second_index < $num_index[0])){ //f->sec.. 
                        $first_number = $second_number; 
                        $second_number = array_pop($num_arr);
                    }else if(($f_word_index < $num_index[0]) && ($second_index < $f_word_index) || ($f_word_index < $num_index[0]) && ( $num_index[0] < $second_index )){
                        $first_number = array_pop($num_arr);
                    }
                    
                }
            }
        }

        // $array = [];
        // for($i=0; $i<10; $i++){
        //     if($i == 3 || $i == 6 || $i == 9){
        //         echo "This is the key and value for array: $i and $array[$i]"; 
        //     }
        // }
        
        //echo "This is the first value: $array[0]";
    
        //case 1: from 1 subtract 2: f>>1>>2 => 1-2 ~ (first number is first operand)
        //case 2: subtract 1 from 2: 1>>f>>2 => 2-1 ~ (second number is first operand)
        if(count($num_arr)>1){
            if($f_word_index == ($num_index[0]-1)){
                $second_number = array_pop($num_arr);
                $first_number = array_pop($num_arr); 
            }else{
                $first_number = array_pop($num_arr); 
                $second_number = array_pop($num_arr);
            }          
        }
        $result = '';

        if (is_numeric($first_number) && is_numeric($second_number)) {
            switch ($operator) {
            case "+":
                $result = $first_number + $second_number;
                $op = "addition";
                break;
            case "-":
                $result = $first_number - $second_number;
                $op = "subtraction";
                break;
            case "*":
                $result = $first_number * $second_number;
                $op = "multiplication";
                break;
            default:
                $result = "Error! Unkown operation";
                $op = "Operation not found";
            }

            return response()->json([
                    'slackUsername' => $second_index.",,".count($num_arr), //"ruxy1212",
                    'result' => $result,
                    'operation_type' => $op
                ]);
        }
    }
}