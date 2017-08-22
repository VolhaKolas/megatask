<?php require_once "partials/header.view.php"?>
<?php require_once "partials/mainnav.view.php"?>
    <div class="wrapper1">
        <?php require_once "partials/leftnav" . \Core\User::role() . ".view.php"?>
        <div class="wrapper2">
            <div class="searchdiv">
                <form class="search">
                    <input type="text" value="Искать пользователя" class="input value">
                </form>
            </div>

            <?php require_once "partials/message.view.php"?>
            <form method="post" action="/group" enctype="multipart/form-data">
                <div class="searchdiv">
                    <input type="text" value="<?= $name?>" name="name" class="input value">
                </div>
                <div class="setroles">
                    <table>
                        <thead>
                        <tr>
                            <th>Логин</th>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Роль</th>
                            <th>Добавить</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user):?>
                            <tr  class="searched">
                                <td><?= $user['u_login']?></td>
                                <td><?= $user['u_name']?></td>
                                <td><?= $user['u_lastname']?></td>
                                <td><?= \Core\Roles::showRole($user['r_id']) ?></td>
                                <td><input type="checkbox" name="<?= $user['u_id']?>"></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="setroles">
                    <input type="submit" value="Создать" class="input">
                </div>
            </form>
        </div>
    </div>
<?php require_once "partials/footer.view.php"?>