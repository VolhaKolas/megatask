<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 03.07.17
 * Time: 3:09
 */

namespace Controller;


use Core\Database;
use Core\Message;

class GiveTestController
{
    //this method shows form to give test to group
    public function test() {
        $message = Message::msg();
        $t_names = Database::select("SELECT t_id, t_name FROM tests");
        $g_names = Database::select("SELECT g_id, g_name FROM groups");
        require_once "views/givetest.view.php";
    }

    //this method allows to give only one test to only one group by one time. By the next time you can add another test to group
    public function give() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            if(2 == count($_POST)) { //only one test and only one group by this time
                $keys = array_keys($_POST);
                $group = [];
                $test = [];
                foreach ($keys as $key) {
                    if(preg_match('/group(\d+)/', $key, $matches))  { //input with matched group
                        $group += [$matches[1]];
                    }
                    else if(preg_match('/test(\d+)/', $key, $match)) { //input with matched test
                        $test += [$match[1]];
                    }
                }
                if((1 == count($group)) and (1 == count($test))) { //only one test and only one group by this time
                    $count = Database::select("SELECT COUNT(*) AS count FROM m2m_group_tests WHERE g_id = \"$group[0]\" AND t_id = \"$test[0]\"");
                    $count = $count[0]['count'];
                    if (0 == $count) {
                        //here I give test
                        Database::insert("m2m_group_tests", ["gt_id" => null, "g_id" => $group[0], "t_id" => $test[0]]);
                    }
                    else {
                        $_SESSION['message'] = "Данный тест уже назначен этой группе";
                    }
                }
                else {
                    $_SESSION['message'] = "Выберите только по одному значению из таблиц";
                }
            }
            else {
                $_SESSION['message'] = "Выберите только по одному значению из таблиц";
            }
        }
        header("Location: /givetest");
    }
}