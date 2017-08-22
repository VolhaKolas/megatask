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

class TestController
{
    //this method shows form for test creation
    public function test() {
        $message = Message::msg();

        $sub = Database::select("SELECT sub_name, ca_id FROM subcategories");
        $subcategories = [];
        foreach ($sub as $s) {
            $ca_id = $s['ca_id'];
            $ca_name = Database::select("SELECT ca_name FROM categories WHERE ca_id = \"$ca_id\"")[0]['ca_name'];
            $subcategories = array_merge($subcategories, [["sub_name" => $s['sub_name'], "ca_name" => $ca_name]]);
        }
        require_once "views/test.view.php";
    }

    //this method creates a test (you need to know numbers of questions to create test)
    public function create() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $t_name = trim($_POST['t_name']);
            $sub = explode("(", $_POST['subcategory']);
            $sub_name = trim($sub[0]);
            $ca_name = trim(substr($sub[1], 0, -1));
            $ca_id = Database::select("SELECT ca_id FROM categories WHERE ca_name = \"$ca_name\"")[0]["ca_id"];//show category ans subcategory
            $sub_id = Database::select("SELECT sub_id FROM subcategories WHERE sub_name = \"$sub_name\" AND ca_id = \"$ca_id\"")[0]['sub_id'];

            $t_showanswer = 0; //show answer or not if exist checkbox
            if(isset($_POST['showanswer'])) {
                $t_showanswer = 1;
            }
            $t_result = 1;//show result or not if exist checkbox
            if(isset($_POST['result'])) {
                $t_result = 0;
            }
            $t_verdict = 1; //show verdict or not if exist checkbox
            if(isset($_POST['verdict'])) {
                $t_verdict = 0;
            }

            $t_threshold = trim($_POST["threshold"]);
            if(isset($_POST['quantity'])) {
                $t_threshold_qty = $t_threshold;
                $t_threshold_per = null;
            }
            else if(isset($_POST['percent'])) {
                $t_threshold_per = $t_threshold;
                $t_threshold_qty = null;
            }
            else {
                $t_threshold_per = null;
                $t_threshold_qty = null;
            }

            if(isset($_POST["answertime"])) {
                $t_answertime = trim($_POST["answertime"]);
            }
            else {
                $t_answertime = '';
            }
            if($t_answertime != "") {
                $t_sumtime = 0;
            }
            else {
                $t_answertime = null;
                $t_sumtime = 1;
            }

            $keys = array_keys($_POST);
            $questionKeys = [];
            foreach ($keys as $key) {
                if (preg_match('/question\d+/', $key, $matches)) { //questions keys creation then I give them on foreach
                    $questionKeys = array_merge($questionKeys, [$matches[0]]);
                }
            }

            $notEmpty = 0;
            foreach ($questionKeys as $qk) {
                if($_POST[$qk] != "") {
                    $notEmpty++;
                }
            }

            if($t_name != "" and $t_threshold != "" and $notEmpty > 0) {
                Database::insert("tests", ["t_id" => null, "t_name" => $t_name, "sub_id" => $sub_id,
                    "t_showanswer" => $t_showanswer, "t_result" => $t_result, "t_verdict" => $t_verdict,
                    "t_threshold_qty" => $t_threshold_qty, "t_threshold_per" => $t_threshold_per,
                    "t_answertime" => $t_answertime, "t_sumtime" => $t_sumtime]);

                foreach ($questionKeys as $questionKey) { //foreach for question keys
                    $q_id = trim($_POST[$questionKey]);
                    $t_id = Database::select("SELECT t_id FROM tests WHERE t_name = \"$t_name\"")[0]['t_id'];
                    Database::insert("m2m_question_tests", ["qt_id" => null, 'q_id' => $q_id, "t_id" => $t_id]);
                }
            }
        }
        header("Location: /test");
    }
}