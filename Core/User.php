<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 02.07.17
 * Time: 2:23
 */

namespace Core;


class User
{
    public static function user() {
        if(isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
    }

    public static function role() {
        $u_login = User::user();
        $r_name = Database::select("SELECT r.r_name FROM roles AS r JOIN users  AS u ON r.r_id = u.r_id 
WHERE u_login = \"$u_login\"")[0]['r_name'];
        if($r_name == "RD-manager") {
            $r_name = 'manager';
        }
        return $r_name;
    }
}