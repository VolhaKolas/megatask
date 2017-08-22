<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 07.07.17
 * Time: 20:15
 */

namespace Core;


class Category
{
    const CATEGORY = "Без категории";
    const SUBCATEGORY = "Без подкатегории";

    public function category() {
        $sql = "SELECT COUNT(*) AS count FROM categories";
        $count = Database::select($sql)[0]['count'];
        if(0 == $count) {
            Database::insert('categories', ["ca_id" => 1, 'ca_name' => self::CATEGORY]);
        }
    }

    public function subcategory() {
        $sql = "SELECT COUNT(*) AS count FROM subcategories";
        $count = Database::select($sql)[0]['count'];
        if(0 == $count) {
            Database::insert('subcategories', ["sub_id" => 1, 'sub_name' => self::SUBCATEGORY, "ca_id" => 1]);
        }
    }
}