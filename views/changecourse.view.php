<?php require_once "partials/header.view.php"?>
<?php require_once "partials/mainnav.view.php"?>
<?php require_once "partials/leftnav" . \Core\User::role() . ".view.php"?>
    <div class="searchdiv">
        <form class="addcourse" method="post" action="/changecourse" enctype="multipart/form-data">
            <label>Текущий курс: <?= $currentCourse ?></label>
            <select name="course" class="input" value="Группа" required>
                <?php foreach ($courses as $course): ?>
                    <option><?= $course['c_name'] ?></option>
                <?php endforeach;?>
            </select>
            <input type="submit" value="Изменить" class="input">
        </form>
    </div>
<?php require_once "partials/footer.view.php"?>