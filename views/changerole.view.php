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


        <div class="setroles">
            <table>
                <thead>
                <tr>
                    <th>Логин</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Роль</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user):?>
                    <tr  class="searched">
                        <td><?= $user['u_login']?></td>
                        <td><?= $user['u_name']?></td>
                        <td><?= $user['u_lastname']?></td>
                        <td>
                            <form action="/changerole" method="post" enctype="multipart/form-data" class="changerole">
                                <select name="<?= $user['u_login']?>" class="input">
                                    <option selected><?= \Core\Roles::showRole($user['r_id']) ?></option>
                                    <?php foreach (\Core\Roles::existingRoles(\Core\Roles::showRole($user['r_id'])) as $role): ?>
                                        <option><?= $role ?></option>
                                    <?php endforeach;?>
                                </select>
                                <input type="submit" value="Изменить" class="input">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once "partials/footer.view.php"?>