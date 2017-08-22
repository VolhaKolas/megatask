<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 28.06.17
 * Time: 21:38
 */

namespace Controller;


use Core\Course;
use Core\Database;
use Core\Hash;
use Core\Message;
use Core\Roles;

class RegisterController
{
    private $login;
    private $password;
    private $name;
    private $lastname;
    private $course;
    private $email;
    private $role;

    const LOGIN = "Логин"; //default value
    const PASSWORD = "Пароль"; //default value
    const NAME = "Имя"; //default value
    const LASTNAME = "Фамилия"; //default value
    const EMAIL = "Email"; //default value
    const COURSE = "Выберите группу:"; //default value


    public function register() {
        $login = self::LOGIN;
        $password = self::PASSWORD;
        $name = self::NAME;
        $lastname = self::LASTNAME;
        $email = self::EMAIL;
        $course = self::COURSE;

        $message = Message::msg();

        $sql = "SELECT c_name FROM courses";
        $courses = Database::select($sql);
        if(0 == count($courses)) {
            $courses = [["c_name" => 'Без направления']];
        }

        require_once "views/register.view.php";
    }

    public function confirm() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            if(isset($_POST['login'])) { //create correct data
                $this->login = trim(htmlentities($_POST['login']));
            }
            if(isset($_POST['password'])) {
                $this->password = trim(htmlentities($_POST['password']));
            }
            if(isset($_POST['name'])) {
                $this->name = trim(htmlentities($_POST['name']));
            }
            if(isset($_POST['lastname'])) {
                $this->lastname = trim(htmlentities($_POST['lastname']));
            }
            if(isset($_POST['course'])) {
                $this->course = trim(htmlentities($_POST['course']));
            }
            if(isset($_POST['email'])) {
                $this->email = trim(htmlentities($_POST['email']));
            }
            if(isset($_POST['role'])) {
                $this->role = trim(htmlentities($_POST['role']));
            }

            if ($this->login != '' and $this->login != self::LOGIN //data tests
                and $this->password != '' and $this->password != self::PASSWORD
                and $this->name != "" and $this->name != self::NAME
                and $this->lastname != '' and $this->lastname != self::LASTNAME
                and $this->course != "" and $this->course != self::COURSE
                and $this->email != "" and $this->email != self::EMAIL) {

                $c_id = Database::select("SELECT c_id FROM courses WHERE c_name = \"$this->course\"")[0]['c_id'];

                $rolename = Roles::LISTENER; //set default role
                $sql3 = "SELECT r_id FROM roles WHERE r_name =\"$rolename\"";
                $role = Database::select($sql3);
                $role = $role[0]['r_id']; //default role id

                $sql1 = "SELECT u_id FROM users WHERE u_login =\"$this->login\""; // check users and email on existence
                $sql2 = "SELECT u_id FROM users WHERE u_email =\"$this->email\"";
                $u_id = Database::select($sql1);
                $u_email = Database::select($sql2);
                if((0 == count($u_id)) and (0 == count($u_email)) and (null !== $u_id)) { //check user is not exist and main user create DB
                    $_SESSION['user'] = $this->login;
                    $this->password = Hash::hash($this->password); //hash password to DB
                    Database::insert("users", ['u_id' => null, 'u_login' => $this->login, 'u_password' => $this->password,
                    'u_name' => $this->name, 'u_lastname' => $this->lastname, 'u_email' => $this->email, 'r_id' => $role,
                    'c_id' => $c_id]); //add user to DB
                    header('Location: /');
                }
                else if(0 == (count($u_id)) and (0 != count($u_email)) and (null !== $u_id)) {
                    $_SESSION['message'] = "Пользователь с данным email уже существует";
                    header('Location: /register');
                }
                else if(null !== $u_id) {
                    $_SESSION['message'] = "Данный пользователь уже зарегистрирован";
                    header('Location: /register');
                }
                else {
                    header('Location: /');
                }
            }
            else {
                $_SESSION['message'] = "Неверный ввод данных";
                header('Location: /register');
            }
        }
    }
}