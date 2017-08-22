<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 02.07.17
 * Time: 20:57
 */

namespace Controller;


use Core\Database;
use Core\Message;
use Core\Roles;

class ChangeRoleController
{
    //shows all users and there roles
    public function role() {
        $message = Message::msg();
        $sql3 = "SELECT u_login, u_name, u_lastname, r_id FROM users";
        $users = Database::select($sql3);
        require_once "views/changerole.view.php";
    }

    //changes user's role
    public function change() {

        $admin_name = Roles::ADMIN; //how "admin" is sign in on db
        $admin_r_id = Database::select("SELECT r_id FROM roles WHERE r_name =\"$admin_name\"")[0]['r_id'];// id of admin name

        $u_login = array_keys($_POST)[0]; //for which user change role
        $r_name = $_POST[$u_login]; //which role will set for this user
        $sql1 = "SELECT r_id FROM roles WHERE r_name = \"$r_name\"";
        $r_id = Database::select($sql1)[0]['r_id'];//id of this role

        $sql2 = "SELECT COUNT(*) AS count FROM users WHERE r_id = \"$admin_r_id\"";
        $count = Database::select($sql2)[0]['count']; //how many admins in the db

        if(1  == $count) {//if there is only one admin in db, make sure that it's not a current user
            $sql3 = "SELECT u_login FROM users WHERE r_id = \"$admin_r_id\"";
            $admin_login = Database::select($sql3)[0]['u_login'];

            if ($admin_login != $u_login) {
                Database::update("users", ["r_id" => $r_id], ['u_login' => $u_login]);
                echo json_encode(["message" => 1]);
            }
            else {
                if($r_name != $admin_name) {
                    echo json_encode(["message" => "Нельзя снять права администратора без назначения нового"]);
                }
            }
        }
        else {
            Database::update("users", ["r_id" => $r_id], ['u_login' => $u_login]);
            echo json_encode(["message" => 1]);
        }
    }
}