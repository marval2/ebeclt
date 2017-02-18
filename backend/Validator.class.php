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
        if(preg_match('/^\d{8}$/',$number)){
            return true;
        }else{
            return false;
        }
    }

    function isText(){

    }

    function isValidDate($date, $format= 'Y-m-d'){
        return true ;//$date == date($format, strtotime($date));
    }

    function isGoodFileFormat($fileName){
        $ext = pathinfo($fileName['name'], PATHINFO_EXTENSION);
        return (
            $ext == "doc"  ||
            $ext == "docx" ||
            $ext == "pdf"  ||
            $ext == "otd"
        )? true:false;
    }

    function isFileNotToBig($fileName,$size = 1000000){
        return ($fileName["size"] < $size)? true:false;
    }
}