<?php require_once "partials/header.view.php"?>
<?php require_once "partials/mainnav.view.php"?>
    <div class="wrapper1">
        <?php require_once "partials/leftnav" . \Core\User::role() . ".view.php"?>
        <div class="wrapper2">
            <?php require_once "partials/message.view.php"?>


            <div class="setroles">
                <table>
                    <thead>
                    <tr>
                        <th>Номер вопроса</th>
                        <th>Содержание вопроса</th>
                        <th>Ответы</th>
                        <th>Картинки</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($questions as $question):?>
                        <tr>
                            <td><?= $question['q_id']?></td>
                            <td><?= $question['q_text']?></td>
                            <td>
                            <?php foreach (\Core\Answers::answers($question['q_id']) as $answer):?>
                                <p style="color: <?= $answer['color']?>"> <?= $answer['a_text']?></p>
                            <?php endforeach;?>
                            </td>
                            <td>
                                <?php foreach (\Core\Answers::pictures($question['q_id']) as $picture):?>
                                    <p><img style="width: 150px;" src="<?= $picture['url'] ?>"></p>
                                <?php endforeach;?>
                            </td>
                            <td><a href="/questionlistdel?question=<?= $question['q_id']?>">Удалить</a></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php require_once "partials/footer.view.php"?>