<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 07.07.17
 * Time: 20:11
 */

namespace Controller;


use Core\Database;

class CategoryController
{
    //this method shows all valuable categories and subcategories, here you can add new category or subcategory
    public function category() {
        $cats = Database::select("SELECT ca_name FROM categories"); //categories
        $sub = Database::select("SELECT sub_name, ca_id FROM subcategories"); //subcategories
        $subcategories = [];
        foreach ($sub as $s) {
            $ca_id = $s['ca_id'];
            $ca_name = Database::select("SELECT ca_name FROM categories WHERE ca_id = \"$ca_id\"")[0]['ca_name'];
            $subcategories = array_merge($subcategories, [["sub_name" => $s['sub_name'], "ca_name" => $ca_name]]);
        }
        require_once "views/category.view.php";
    }

    //this method add new category to DB
    public function addcategory() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $ca_name = trim($_POST['ca_name']); //new category name
            if($ca_name != "" and (preg_match("/\(/", $ca_name, $m) == false)) {
                $count = Database::select("SELECT COUNT(*) AS count FROM categories WHERE ca_name = \"$ca_name\"")[0]['count'];
                if(0 == $count) {
                    Database::insert('categories', ["ca_id" => null, "ca_name" => $ca_name]);
                }
            }
        }
        header("Location: /category");
    }

    //this method adds new subcategory to DB
    public function addsubcategory() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $sub_name = trim($_POST['sub_name']); //new subcategory name
            $ca_name = $_POST['ca_name']; //to which category add new subcategory
            $ca_id = Database::select("SELECT ca_id FROM categories WHERE ca_name = \"$ca_name\"")[0]['ca_id'];
            if($sub_name != "" and (preg_match("/\(/", $sub_name, $m) == false)) {
                $count = Database::select("SELECT COUNT(*) AS count FROM subcategories WHERE sub_name = \"$sub_name\"")[0]['count'];
                if(0 == $count) {
                    Database::insert('subcategories', ["sub_id" => null, "sub_name" => $sub_name, "ca_id" => $ca_id]);
                }
            }
        }
        header("Location: /category");
    }

    //this method deletes category
    public function delcategory() {
        if($_SERVER["REQUEST_METHOD"] == "GET") {
            $ca_name = $_GET['ca_name']; //category name to delete
            Database::delete("categories", ["ca_name" => $ca_name]);
        }
        header("Location: /category");
    }

    //this method deletes subcategory
    public function delsubcategory() {
        if($_SERVER["REQUEST_METHOD"] == "GET") {
            $sub_name = $_GET['sub_name']; //subcategory name to delete
            Database::delete("subcategories", ["sub_name" => $sub_name]);
        }
        header("Location: /category");
    }
}