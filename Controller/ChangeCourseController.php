<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 04.07.17
 * Time: 3:06
 */

namespace Controller;


use Core\Course;
use Core\Database;
use Core\User;

class ChangeCourseController
{
    //this method shows all available courses and current user course
    public function change() {
        $u_login = User::user();
        if((Database::select("SELECT COUNT(*) AS count FROM users WHERE u_login=\"$u_login\""))[0]['count'] > 0) {
            $courses = Database::select("SELECT c_name FROM courses"); //all courses (data for view)
            $c_id = Database::select("SELECT c_id FROM users WHERE u_login = \"$u_login\""); //current user's course
            if ($c_id == null) {
                $c_name = Course::COURSE; //set course "Без направления"
                $c_id = Database::select("SELECT c_id FROM courses WHERE c_name=\"$c_name\"")[0]['c_id'];
                Database::update('users', ['c_id' => $c_id], ['u_login' => $u_login]); //update user course if current course if null
            }
            else {
                $c_id = $c_id[0]['c_id'];
            }
            $currentCourse = Database::select("SELECT c_name FROM courses WHERE c_id = \"$c_id\"")[0]['c_name']; //data for view
            require_once "views/changecourse.view.php";
        }
        else {
            require_once "views/admin.view.php";
        }
    }

    //this method changes user course
    public function course() {
        if(isset($_POST['course'])) {
            $u_login = User::user();
            $course = $_POST['course'];
            $c_id = Database::select("SELECT c_id FROM courses WHERE c_name= \"$course\"")[0]['c_id'];
            Database::update("users", ['c_id' => $c_id], ['u_login' => $u_login]);
        }
        header("Location: /changecourse");
    }
}