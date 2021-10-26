<?php 
class SanitizerForm{
    public static function sanitizeFormString($input){
        $input = strip_tags($input);
        $input = str_replace(" ", "", $input);
        $input =strtolower($input);
        $input = ucfirst($input);
        return $input;
    }
    public static function sanitizeUsername($input){
        $input = strip_tags($input);
        $input = str_replace(" ", "", $input);
        return $input;
    }
    public static function sanitizePassword($input){
        $input = strip_tags($input);
        return $input;
    }
    public static function sanitizeFormEmail($input){
        $input = strip_tags($input);
        $input = str_replace(" ", "", $input);
        return $input;
    }
    
}


?>