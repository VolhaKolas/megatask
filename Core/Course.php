<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 04.07.17
 * Time: 0:51
 */

namespace Core;


class Course
{
    const COURSE = "Без направления";

    public function course() {
        $sql = "SELECT COUNT(*) AS count FROM courses";
        $count = Database::select($sql)[0]['count'];
        if(0 == $count) {
            Database::insert('courses', ["c_id" => 1, 'c_name' => self::COURSE]);
        }
    }
}