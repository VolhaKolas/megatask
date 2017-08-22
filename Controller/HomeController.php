<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 28.06.17
 * Time: 21:42
 */

namespace Controller;


use Core\Database;
use Core\Message;
use Core\Roles;
use Core\User;

class HomeController
{

    //method shows main page when user is not login and is login
    public function home() {
        $sql3 = "SELECT u_login, u_name, u_lastname, r_id FROM users";
        $users = Database::select($sql3);
        if(!isset($_SESSION['user'])) {//user is not login
            require_once "views/home.view.php";
        }
        else {//user is login
            if(isset($_SESSION['admin'])) {
                require_once "views/main.view.php";
            }

            $user = User::user();//here I set SESSION for only once determine from DB user role and what I must show to him
            $sql1 = "SELECT r_id FROM users WHERE u_login = \"$user\"";
            $role_id = Database::select($sql1);
            if(count($role_id) > 0) {
                $role_id = $role_id[0]['r_id'];
                $sql2 = "SELECT r_name FROM roles WHERE r_id = \"$role_id\"";
                $role = Database::select($sql2);
                $role = $role[0]['r_name'];


                if ($role == Roles::ADMIN) {
                    $_SESSION['admin'] = $user;
                }

                else if ($role == Roles::MANAGER) {
                    $_SESSION['manager'] = $user;
                }
                else if ($role == Roles::TRAINER) {
                    $_SESSION['trainer'] = $user;
                }
                require_once "views/main.view.php";
            }
        }
    }
}