<?php

$router->get("", "HomeController@home");

if(!isset($_SESSION['user'])) {
    $router->get("register", "RegisterController@register");
    $router->get("login", "LoginController@login");
    $router->post("register", "RegisterController@confirm");
    $router->post("login", "LoginController@confirm");
}
else {
    $router->get("logout", "LogoutController@logout");

    if(isset($_SESSION['admin'])) {
        $router->get("changerole", "ChangeRoleController@role");
        $router->post("changerole", "ChangeRoleController@change");
    }

    if(isset($_SESSION['admin']) or isset($_SESSION['manager'])) {
        $router->get("course", "CourseController@course");
        $router->post("course", "CourseController@edit");
        $router->get("delcourse", "CourseController@delete");

        $router->get("question1", "QuestionController@question");
        $router->post("question1", "QuestionController@create");

        $router->get("question2", "Question2Controller@question");
        $router->post("question2", "Question2Controller@create");

        $router->get("category", "CategoryController@category");
        $router->post("addcategory", "CategoryController@create");
        $router->post("addcategory", "CategoryController@addcategory");
        $router->post("addsubcategory", "CategoryController@addsubcategory");
        $router->get("delcategory", "CategoryController@delcategory");
        $router->get("delsubcategory", "CategoryController@delsubcategory");

        $router->get("questionslist", "QuestionsListController@question");
        $router->get("questionlistdel", "QuestionsListController@delete");

        $router->get("test", "TestController@test");
        $router->post("test", "TestController@create");
    }

    if(isset($_SESSION['admin']) or isset($_SESSION['manager']) or isset($_SESSION['trainer'])) {
        $router->get("group", "GroupController@group");
        $router->post("group", "GroupController@create");

        $router->get("givetest", "GiveTestController@test");
        $router->post("givetest", "GiveTestController@give");
    }

    $router->get("changecourse", "ChangeCourseController@change");
    $router->post("changecourse", "ChangeCourseController@course");

    $router->get("passtest", "PassTestController@test");
    $router->get("pass", "PassTestController@show");
    $router->post("pass", "PassTestController@pass");
}
