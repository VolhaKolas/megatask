<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 28.06.17
 * Time: 21:39
 */

namespace Controller;


use Core\Database;
use Core\Hash;
use Core\Message;
use Core\Roles;

class LoginController
{
    const LOGIN = "Логин";
    const PASSWORD = "Пароль";

    //shows login form
    public function login() {
        $login = self::LOGIN; //default value for form
        $password = self::PASSWORD; //default value for form

        $message = Message::msg();
        require_once "views/login.view.php";
    }

    //creates enter or not if incorrect form data
    public function confirm() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            if(isset($_POST['login'])) {
                $this->login = trim(htmlentities($_POST['login']));
            }
            if(isset($_POST['password'])) {
                $this->password = trim(htmlentities($_POST['password']));
            }

            if ($this->login != '' and $this->login != self::LOGIN
                and $this->password != '' and $this->password != self::PASSWORD)
            {

                $adminConf = require_once "admin.php"; //if there aren't any admin in DB the fisrt enter for admin - (look - admin.php)

                $r_name = Roles::ADMIN;
                $sql1 = "SELECT r_id FROM roles WHERE r_name =\"$r_name\"";
                $role_id = Database::select($sql1);
                if(count($role_id) > 0) {
                    $role_id = $role_id[0]['r_id'];
                    $sql2 = "SELECT COUNT(*) AS count FROM users WHERE r_id = \"$role_id\"";
                    $count = Database::select($sql2);
                    $count = $count[0]['count']; //how many admin in DB
                }

                $sql = "SELECT u_password FROM users WHERE u_login =\"$this->login\"";
                $u_psw = Database::select($sql);
                if($u_psw !== null) {
                    if (count($u_psw) > 0) {
                        if (Hash::hash($this->password) == $u_psw[0]['u_password']) { //check password
                            $_SESSION['user'] = $this->login;
                            header('Location: /');
                        } else {
                            $_SESSION['message'] = "Неверный пароль";
                            header('Location: /login');
                        }
                    } else if (0 == $count and $this->login == $adminConf['login'] and $this->password == $adminConf['password']) {
                        //if there isn't any admin in DB and (data correct (look - admin.php))
                        $_SESSION['user'] = $this->login;
                        $_SESSION['admin'] = $this->login;
                        header('Location: /');
                    } else {
                        $_SESSION['message'] = "Данного пользователя не существует";
                        header('Location: /login');
                    }
                }
                else {
                    header('Location: /');
                }
            }
            else {
                $_SESSION['message'] = "Неверный ввод данных";
                header('Location: /login');
            }
        }
    }
}