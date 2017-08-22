<?php require_once "partials/header.view.php"?>
<?php require_once "partials/homenav.view.php"?>
<?php require_once "partials/message.view.php"?>
    <div class="formwrapper">
        <h2>Войти</h2>
        <form method="post" action="/login" enctype="multipart/form-data">
            <input type="text" name="login" class="input value" value="<?= $login ?>" required>
            <input type="password" name="password" class="input value" value="<?= $password ?>" required>
            <input type="submit" value="Войти" class="input">
        </form>
    </div>
<?php require_once "partials/footer.view.php"?>