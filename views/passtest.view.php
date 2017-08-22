<?php require_once "partials/header.view.php"?>
<?php require_once "partials/mainnav.view.php"?>
    <div class="wrapper1">
        <?php require_once "partials/leftnav" . \Core\User::role() . ".view.php"?>
        <div class="wrapper2">
            <div class="wrappertest">
                <?php foreach ($tests as $test):?>
                    <div class="tests">
                        <a href="/pass?id=<?=$test['t_id']?>&name=<?= $test['t_name']?>"><?= $test['t_name']?></a>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
<?php require_once "partials/footer.view.php"?>