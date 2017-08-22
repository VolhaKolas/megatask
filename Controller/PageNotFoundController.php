<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 29.06.17
 * Time: 0:29
 */

namespace Controller;


class PageNotFoundController
{
    public function page() {
        require_once "views/pagenotfound.view.php";
    }
}