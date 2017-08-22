<?php require_once "partials/header.view.php"?>
<?php require_once "partials/mainnav.view.php"?>
    <div class="wrapper1">
        <?php require_once "partials/leftnav" . \Core\User::role() . ".view.php"?>
        <div class="wrapper2">

            <div class="adddiv">
                <form class="addcourse" method="post" action="/addcategory" enctype="multipart/form-data">
                    <input type="text" name="ca_name" value="Добавить категорию" class="input value">
                    <input type="submit" value="Добавить" class="input">
                </form>
            </div>

            <div class="adddiv">
                <form class="addcourse" method="post" action="/addsubcategory" enctype="multipart/form-data">
                    <input type="text" name="sub_name" value="Добавить подкатегорию" class="input value">
                    <select name="ca_name" class="input">
                        <?php foreach ($cats as $cat): ?>
                        <option><?= $cat['ca_name']?></option>
                        <?php endforeach;?>
                    </select>
                    <input type="submit" value="Добавить" class="input">
                </form>
            </div>


            <div class="setroles">
                <table>
                    <thead>
                    <tr>
                        <th>Подкатегория</th>
                        <th>Удалить</th>
                        <th>Категория</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($subcategories as $subcategory): ?>
                        <tr class="searchedcourse">
                            <td><?= $subcategory['sub_name'] ?></td>
                            <td><a href="/delsubcategory?sub_name=<?= $subcategory['sub_name']?>&ca_name=<?= $subcategory['ca_name']?>">Удалить</a></td>
                            <td><?= $subcategory['ca_name'] ?></td>
                            <td><a href="/delcategory?ca_name=<?= $subcategory['ca_name']?>">Удалить</a></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php require_once "partials/footer.view.php"?>