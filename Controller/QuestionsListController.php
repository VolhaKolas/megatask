<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 07.07.17
 * Time: 3:45
 */

namespace Controller;


use Core\Database;
use Core\Message;

class QuestionsListController
{
    //method shows all question
    public function question() {
        $questions = Database::select("SELECT q_id, q_text FROM questions");
        $message = Message::msg();
        require_once "views/questionslist.view.php";
    }

    //method delete question only if question is not a part of test
    public function delete() {
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            $q_id = $_GET['question'];
            $exist = Database::select("SELECT COUNT(*) AS count FROM m2m_question_tests WHERE q_id = \"$q_id\"")[0]['count'];
            if(0 == $exist) {
                Database::delete("questions", ["q_id" => $q_id]);
            }
            else {
                $_SESSION['message'] = "Невозможно удалить вопрос";
            }
        }
        header("Location: /questionslist");
    }
}