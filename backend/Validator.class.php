<?php

/**
 * Created by PhpStorm.
 * User: Slivinskas
 * Date: 2017-01-24
 * Time: 12:53
 */
class Validator
{
    function isName($name){
        if(preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u", $name, $error) !== 0){
            return true;
        }else{
            return false;
        }
    }

    function isEmail($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }else{
            return false;
        }
    }

    function isPhoneNumber($number){
        if(preg_match('/^\d{6}$/',$number)){
            return true;
        }else{
            return false;
        }
    }

    function isText(){

    }

    function isDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function isGoodFileFormat($fileName){
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if(
            $ext == "doc"  ||
            $ext == "docx" ||
            $ext == "pdf"  ||
            $ext == "otd"
        ){
            return true;
        }else{
            return false;
        }
    }
}