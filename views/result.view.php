<?php require_once "partials/header.view.php"?>
<?php require_once "partials/mainnav.view.php"?>
        <div class="quest">
            <h2><?= $verdict?></h2>
            <h2><?= $res?></h2>
        </div>

        <div class="result">
            <table>
                <thead>
                <tr>
                    <th>Содержание вопроса</th>
                    <th>Ответы</th>
                    <th>Картинки</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($questions as $question):?>
                    <tr>
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
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>

<?php require_once "partials/footer.view.php"?>