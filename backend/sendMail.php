<?php
/**
 * Created by PhpStorm.
 * User: Acer-pc
 * Date: 2017-02-01
 * Time: 08:01
 */

include_once ("Mail.class.php");

$mail = new Mail();
$urte = "NAURT11@GMAIL.COM";

$mail->send("slivinskasvytenis@gmail.com","slivinskasvytenis@hotmail.com");