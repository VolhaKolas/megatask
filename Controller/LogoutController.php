<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 01.07.17
 * Time: 2:29
 */

namespace Controller;


class LogoutController
{
    public function logout() {
        session_destroy();
        header('Location: /');
    }
}