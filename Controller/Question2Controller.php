<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 07.07.17
 * Time: 0:25
 */

namespace Controller;


use Core\Database;
use Core\Message;
use Core\Upload;

class Question2Controller
{
    const EXTENSION1 = "jpg";
    const EXTENSION2 = "jpeg";
    const EXTENSION3 = "png";
    const EXTENSION4 = "gif";

    private $fileupload;

    //method shows form for creation question of second type
    public function question() {
        $message = Message::msg();
        require_once "views/question2.view.php";
    }

    //method create a question of first type
    public function create() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $arrayKeys = array_keys($_POST);
            $keys = [];
            foreach ($arrayKeys as $key) {
                if($_POST[$key] != '' and $_POST[$key] != null) {
                    $keys = array_merge($keys, [$key]);
                }
            }

            $question = null;
            $checkboxes = [];
            $answers = [];
            foreach ($keys as $order => $k) {
                if($k == "question") {
                    $question = $_POST[$k]; // question test (textarea value)
                }
                else if(preg_match('/checkbox(\d+)/', $k, $matches)) { //all checkboxes which user checked
                    $checkboxes = array_merge($checkboxes, [(int)$matches[1]]);
                }
                else if(preg_match('/(answer(\d+))/', $k, $mat)) { //all answers
                    $answers += [(int)$mat[2] => $mat[1]]; //for cycle
                }
            }


            if((count($keys) > 3) and ($question != null) and ($checkboxes != [])
                and (count($checkboxes) != 0)) {

                Database::insert("questions", ["q_id" => null, "q_text" => $question,
                    "q_weight" => 50, "q_time" => 30]); //create question
                $q_id = Database::select("SELECT q_id FROM questions WHERE q_text = \"$question\"");
                $q_id = $q_id[count($q_id) - 1]["q_id"]; //take question id to add answers to DB using id
                foreach ($answers as $ord => $m) {
                    if (in_array($ord, $checkboxes)) { //correct answers to DB
                        Database::insert("answers", ["a_id" => null, "a_text" => $_POST[$m],
                            "a_correct" => 1, "q_id" => $q_id]);
                    }
                    else { //incorrect answer to DB
                        Database::insert("answers", ["a_id" => null, "a_text" => $_POST[$m],
                            "a_correct" => 0, "q_id" => $q_id]);
                    }
                }

                foreach ($_FILES as $file) { //if there are pictures I insert them to DB and Upload
                    if(isset($file) and $file['name'] != '') {
                        $fileName = $file['name'];
                        $extension = pathinfo($fileName)['extension'];
                        if($extension == self::EXTENSION1 or $extension == self::EXTENSION2 or
                            $extension == self::EXTENSION3 or $extension == self::EXTENSION4) {
                            Database::insert("pictures", ['p_id' => null, 'p_url' => $fileName, 'q_id' => $q_id]);
                            $this->fileupload = new Upload();
                            $this->fileupload->startupload($file, $q_id);
                        }
                    }
                }
            }
            else {
                $_SESSION['message'] = "Недостаточно данных для создания вопроса";
            }
            header("Location: /question2");
        }
    }
}