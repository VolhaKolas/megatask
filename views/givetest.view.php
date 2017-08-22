<?php require_once "partials/header.view.php"?>
<?php require_once "partials/mainnav.view.php"?>
    <div class="wrapper1">
        <?php require_once "partials/leftnav" . \Core\User::role() . ".view.php"?>
    <div class="wrapper2">
        <?php require_once "partials/message.view.php"?>
        <form method="post" action="/givetest" enctype="multipart/form-data">
            <div class="settest">
                <table>
                    <thead>
                    <tr>
                        <th>Название группы</th>
                        <th>Выбрать</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($g_names as $g_name):?>
                        <tr>
                            <td><?= $g_name['g_name']?></td>
                            <td><input type="checkbox" name="group<?= $g_name['g_id'] ?>"></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="settest">
                <table>
                    <thead>
                    <tr>
                        <th>Название теста</th>
                        <th>Выбрать</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($t_names as $t_name):?>
                        <tr>
                            <td><?= $t_name['t_name']?></td>
                            <td><input type="checkbox" name="test<?= $t_name['t_id'] ?>"></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="setroles">
                <input type="submit" class="input" value="Создать">
            </div>
        </form>
    </div>
</div>
<?php require_once "partials/footer.view.php"?>