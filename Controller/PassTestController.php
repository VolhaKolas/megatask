<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 08.07.17
 * Time: 17:02
 */

namespace Controller;


use Core\Database;
use Core\User;

class PassTestController
{
    private function question($t_id) {
        return Database::select("SELECT q.q_id, q.q_text FROM questions q 
JOIN m2m_question_tests qt ON q.q_id = qt.q_id WHERE qt.t_id = \"$t_id\"ORDER BY q.q_id");
    }

    //shows all user test
    public function test() {
        $u_login = User::user();
        $tests = Database::select("SELECT t_id, t_name FROM tests WHERE t_id IN 
(SELECT gt.t_id FROM m2m_user_groups ug JOIN m2m_group_tests gt ON ug.g_id = gt.g_id WHERE ug.u_id = 
(SELECT u_id FROM users WHERE u_login = \"$u_login\"))");
        require_once "views/passtest.view.php";
    }

    //shows question in test or result and add to DB results of the questions or test
    public function pass() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            //to add result to DB I need u_id, t_id, q_id
            $u_login = User::user();
            $u_id = Database::select("SELECT u_id FROM users WHERE u_login = \"$u_login\"")[0]['u_id'];
            $t_id = $_GET['id'];
            $t_name = $_GET['name']; //for view
            $q_id = $_POST['question'];
            $q_order = $_POST['q_order'] + 1; //next question which I must show to user
            $questions = $this->question($t_id); //all questions in test
            $keys = array_keys($_POST);
            $a_ids = [];
            $testexist = Database::select("SELECT COUNT(*) AS count FROM m2m_user_tests 
WHERE u_id = \"$u_id\" AND t_id = \"$t_id\"")[0]['count']; //check if user've done this test
            foreach ($keys as $key) {
                if (preg_match("/^\d+$/", $key, $matches)) { //answers which users consider as correct
                    $a_ids = array_merge($a_ids, [$matches[0]]);
                }
            }
            $correct_a_ids = Database::select("SELECT a_id, a_correct FROM answers WHERE q_id= \"$q_id\""); //all answers on this question form DB
            $uq_correct = 1;
            foreach ($correct_a_ids as $correct_a_id) {//if only ane answer not identical to DB data, I consider this question as not done
                if(((in_array($correct_a_id['a_id'], $a_ids) == true) and ($correct_a_id['a_correct'] != 1)) or
                    ((in_array($correct_a_id['a_id'], $a_ids) == false) and ($correct_a_id['a_correct'] == 1))) {
                    $uq_correct = 0;
                }
            }
            $exist = Database::select("SELECT COUNT(*) AS count FROM m2m_user_questions 
WHERE u_id = \"$u_id\" AND q_id = \"$q_id\" AND t_id = \"$t_id\"")[0]['count']; //insert question results only if result's not exist
            if(0 == $exist) {
                Database::insert("m2m_user_questions", ['uq_id' => null, 'u_id' => $u_id, 'q_id' => $q_id,
                    't_id' => $t_id, 'uq_correct' => $uq_correct]);
            }
            if($q_order >= count($questions) or $testexist != 0) { //check the number of question. If it is the last, redirect to result view
                //if end of test, add result to DB and show results
                $results = Database::select("SELECT t_showanswer, t_result, t_verdict FROM tests WHERE t_id = \"$t_id\"");
                $t_showanswer = $results[0]['t_showanswer'];
                $t_result = $results[0]['t_result'];
                $t_verdict = $results[0]['t_verdict'];

                //calculation correct test or not for this user
                $ut_correct = 1;
                $correctAnswers = Database::select("SELECT COUNT(*) AS count FROM m2m_user_questions 
WHERE u_id =\"$u_id\" AND t_id = \"$t_id\" AND uq_correct = 1")[0]['count'];
                $commonAnswers = Database::select("SELECT COUNT(*) AS count FROM m2m_user_questions 
WHERE u_id =\"$u_id\" AND t_id = \"$t_id\"")[0]['count'];
                $t_threshold = Database::select("SELECT t_threshold_qty, t_threshold_per FROM tests WHERE t_id= \"$t_id\"");
                $t_threshold_qty = $t_threshold[0]['t_threshold_qty'];
                $t_threshold_per = $t_threshold[0]['t_threshold_per'];
                if ($t_threshold_qty == null) { //if threshold is on percent
                    $percent = round(($correctAnswers / $commonAnswers) * 100); //the percent of correct answers
                    if ($percent < $t_threshold_per) {
                        $ut_correct = 0;
                    }
                } else {//if threshold is a quantity of correct answers
                    if ($correctAnswers < $t_threshold_qty) {
                        $ut_correct = 0;
                    }
                }
                $count = Database::select("SELECT COUNT(*) count FROM m2m_user_tests WHERE u_id = \"$u_id\" AND t_id = \"$t_id\"");
                $count = $count[0]['count']; //check for only one insert
                if (0 == $count) {
                    Database::insert('m2m_user_tests', ['ut_id' => null, 'u_id' => $u_id, 't_id' => $t_id,
                        'ut_correct' => $ut_correct, 'ut_times' => 1]);
                }

                $verdict = "";
                if($t_verdict != 0) {
                    if(0 == $ut_correct) {
                        $verdict = "Тест не пройден";
                    }
                    else {
                        $verdict = "Тест пройден";
                    }
                }

                $res = "";
                if($t_result != 0) {
                    if($t_threshold_qty == null) {
                        $res = $percent . "%";
                    }
                    else {
                        $res = $correctAnswers . ' правильных ответов.';
                    }
                }
                if($t_showanswer != 0) {
                    $questions = Database::select("SELECT q_id, q_text FROM questions");
                }
                if($t_verdict != 0 or $t_showanswer != 0 or $t_result != 0) {
                    $questions = Database::select("SELECT q_id, q_text FROM questions");
                    require_once "views/result.view.php";
                }
                else {
                    header("Location: /");
                }
            }
            else {
                $question = $questions[$q_order];
                $answers = \Core\Answers::answers($question['q_id']);
                $pictures = \Core\Answers::pictures($question['q_id']);
                require_once "views/showtest.view.php";
            }
        }
    }

    //shows first question
    public function show() {
        if($_SERVER["REQUEST_METHOD"] == "GET") {
            $u_login = User::user();
            $u_id = Database::select("SELECT u_id FROM users WHERE u_login = \"$u_login\"")[0]['u_id'];
            $t_id = $_GET['id'];
            $t_name = $_GET['name'];
            $testexist = Database::select("SELECT COUNT(*) AS count FROM m2m_user_tests 
WHERE u_id = \"$u_id\" AND t_id = \"$t_id\"")[0]['count']; //check if user've done this test
            if($testexist != 0) {
                //if end of test, show results
                $results = Database::select("SELECT t_showanswer, t_result, t_verdict FROM tests WHERE t_id = \"$t_id\"");
                $t_showanswer = $results[0]['t_showanswer'];
                $t_result = $results[0]['t_result'];
                $t_verdict = $results[0]['t_verdict'];
                //calculation correct test or not for this user
                $ut_correct = 1;
                $correctAnswers = Database::select("SELECT COUNT(*) AS count FROM m2m_user_questions 
WHERE u_id =\"$u_id\" AND t_id = \"$t_id\" AND uq_correct = 1")[0]['count'];
                $commonAnswers = Database::select("SELECT COUNT(*) AS count FROM m2m_user_questions 
WHERE u_id =\"$u_id\" AND t_id = \"$t_id\"")[0]['count'];
                $t_threshold = Database::select("SELECT t_threshold_qty, t_threshold_per FROM tests WHERE t_id= \"$t_id\"");
                $t_threshold_qty = $t_threshold[0]['t_threshold_qty'];
                $t_threshold_per = $t_threshold[0]['t_threshold_per'];
                if ($t_threshold_qty == null) { //if threshold is on percent
                    $percent = round(($correctAnswers / $commonAnswers)) * 100; //the percent of correct answers
                    if ($percent < $t_threshold_per) {
                        $ut_correct = 0;
                    }
                } else {//if threshold is a quantity of correct answers
                    if ($correctAnswers < $t_threshold_qty) {
                        $ut_correct = 0;
                    }
                }
                $count = Database::select("SELECT COUNT(*) count FROM m2m_user_tests WHERE u_id = \"$u_id\" AND t_id = \"$t_id\"");
                $count = $count[0]['count']; //check for only one insert
                if (0 == $count) {
                    Database::insert('m2m_user_tests', ['ut_id' => null, 'u_id' => $u_id, 't_id' => $t_id,
                        'ut_correct' => $ut_correct, 'ut_times' => 1]);
                }

                $verdict = "";
                if($t_verdict != 0) {
                    if(0 == $ut_correct) {
                        $verdict = "Тест не пройден";
                    }
                    else {
                        $verdict = "Тест пройден";
                    }
                }

                $res = "";
                if($t_result != 0) {
                    if($t_threshold_qty == null) {
                        $res = $percent . "%";
                    }
                    else {
                        $res = $correctAnswers . ' правильных ответов.';
                    }
                }

                if($t_showanswer != 0) {
                    $questions = Database::select("SELECT q_id, q_text FROM questions");
                }
                if($t_verdict != 0 or $t_showanswer != 0 or $t_result != 0) {
                    $questions = Database::select("SELECT q_id, q_text FROM questions");
                    require_once "views/result.view.php";
                }
                else {
                    header("Location: /");
                }

            }
            else {
                $q_order = 0;
                $question = $this->question($t_id)[$q_order];
                $answers = \Core\Answers::answers($question['q_id']);
                $pictures = \Core\Answers::pictures($question['q_id']);
                require_once "views/showtest.view.php";
            }
        }
    }
}