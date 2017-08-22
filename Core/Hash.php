<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 01.07.17
 * Time: 2:06
 */

namespace Core;


class Hash
{
    public static function hash($data) {
        return sha1($data);
    }
}