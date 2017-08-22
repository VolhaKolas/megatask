<?php require_once "partials/header.view.php"?>
<?php require_once "partials/homenav.view.php"?>
<?php require_once "partials/message.view.php"?>
    <div class="formwrapper">
        <h2>Регистрация</h2>
        <form method="post" action="/register" enctype="multipart/form-data">
            <input type="text" name="login" class="input value" value="<?= $login ?>" required>
            <input type="password" name="password" class="input value" value="<?= $password ?>" required>
            <input type="text" name="name" class="input value" value="<?= $name ?>" required>
            <input type="text" name="lastname" class="input value" value="<?= $lastname ?>" required>
            <select name="course" class="input" value="Группа" required>
                <option disabled selected><?= $course?></option>
                <?php foreach ($courses as $cour): ?>
                    <option><?= $cour['c_name'] ?></option>
                <?php endforeach;?>
            </select>
            <input type="email" name="email" class="input value" value="<?= $email ?>" required>
            <input type="submit" value="Зарегистрироваться" class="input">
        </form>
    </div>
<?php require_once "partials/footer.view.php"?>