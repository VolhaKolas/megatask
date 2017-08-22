<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 03.07.17
 * Time: 3:08
 */

namespace Controller;


use Core\Database;
use Core\Message;

class GroupController
{
    const NAME = "Название группы";

    //method shows all users whom you can add to group with name you want
    public function group() {
        $name = self::NAME;
        $message = Message::msg(); //if user done something wrong
        $sql3 = "SELECT u_id, u_login, u_name, u_lastname, r_id FROM users";
        $users = Database::select($sql3);
        require_once "views/group.view.php";
    }

    //method creates group with users you selected
    public function create() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $name = trim($_POST['name']); //group name
            $exist = Database::select("SELECT COUNT(*) AS count FROM groups WHERE g_name = \"$name\"")[0]['count'];
            if(($name != '') and (0 == $exist) and (count($_POST) > 1)) {
                Database::insert("groups", ["g_id" => null, "g_name" => $name]); //new group creation
                $ks = array_keys($_POST);
                $keys = [];
                foreach ($ks as $k) {
                    if ($k != "name") {
                        $keys = array_merge($keys, [$k]);
                    }
                }
                foreach ($keys as $key) { //keys with user's ids. Here I add user ids to DB
                    $g_id = Database::select("SELECT g_id FROM groups WHERE g_name = \"$name\"")[0]['g_id'];
                    Database::insert("m2m_user_groups", ["ug_id" => null, "u_id" => $key, "g_id" => $g_id]);
                }
            }
            else {
                $_SESSION['message'] = "Группа с таким названием существует";
            }
        }
        header("Location: /group");
    }
}