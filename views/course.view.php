<?php require_once "partials/header.view.php"?>
<?php require_once "partials/mainnav.view.php"?>
    <div class="wrapper1">
        <?php require_once "partials/leftnav" . \Core\User::role() . ".view.php"?>
        <div class="wrapper2">
            <div class="searchdiv">
                <form class="searchcourse">
                    <input type="text" value="Искать курс" class="input value">
                </form>
            </div>

            <div class="adddiv">
                <form class="addcourse" method="post" action="/course" enctype="multipart/form-data">
                    <input type="text" name="c_name" value="Добавить курс" class="input value">
                    <input type="submit" value="Добавить" class="input">
                </form>
            </div>


            <div class="message"></div>
            <div class="setroles">
                <table>
                    <thead>
                    <tr>
                        <th>Название курса</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($courses as $course): ?>
                        <tr class="searchedcourse">
                            <td><?= $course['c_name']?></td>
                            <td><a href="/delcourse?c_name=<?= $course['c_name']?>">Удалить</a></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php require_once "partials/footer.view.php"?>