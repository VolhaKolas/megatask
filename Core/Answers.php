<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 08.07.17
 * Time: 2:03
 */

namespace Core;


class Answers
{
    public static function answers($q_id) { //answers for questions list
        $ans = Database::select("SELECT a_id, a_text, a_correct FROM answers WHERE q_id = \"$q_id\"");
        $answers = [];
        foreach ($ans as $an) {
            if(1 == $an['a_correct']) {
                $color = "green";
            }
            else {
                $color = "red";
            }
            $answers = array_merge($answers, [["a_id" => $an['a_id'], 'a_text' => $an['a_text'], 'color' => $color]]);
        }
        return $answers;
    }

    public static function pictures($q_id) { //pictures for question list
        $pics = Database::select("SELECT p_url FROM pictures WHERE q_id = \"$q_id\"");
        $pictures = [];
        if(count($pics) > 0) {
            foreach ($pics as $pic) {
                $path = "files/" . $q_id . "/" . sha1($pic['p_url']);
                $pictures = array_merge($pictures, [['url' => $path]]);
            }
        }
        return $pictures;
    }
}