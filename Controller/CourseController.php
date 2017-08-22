<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 03.07.17
 * Time: 3:07
 */

namespace Controller;


use Core\Database;

class CourseController
{
    //method shows all courses (by default the first course - "Без направления"; look - index.php)
    public function course() {
        $courses = Database::select("SELECT c_name FROM courses");
        require_once "views/course.view.php";
    }

    //method edits current course
    public function edit() {
        if(isset($_POST['c_name']) and $_POST['c_name'] != "") {
            $c_name = $_POST['c_name'];
            Database::insert("courses", ['c_id' => null, 'c_name' => $c_name]);
        }
        header("Location: /course");
    }

    //method deletes courses (all courses except "Без направления")
    public function delete() {
        if(isset($_GET['c_name']) and $_GET['c_name'] != "") {
            $c_name = $_GET['c_name'];
            Database::delete("courses", ['c_name' => $c_name]);
        }
        header("Location: /course");
    }
}