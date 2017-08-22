<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 01.07.17
 * Time: 1:59
 */

namespace Core;


class Message
{
    public static function msg() {
        if(isset($_SESSION['message']) and $_SESSION['message'] != null) {
            $message = $_SESSION['message'];
            $_SESSION['message'] = null;
        }
        else {
            $message = '';
        }
        return $message;
    }
}