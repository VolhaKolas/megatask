<?php require_once "partials/header.view.php"?>
<?php require_once "partials/mainnav.view.php"?>
<div>
    <div><h2><?= $t_name ?></h2></div>
    <form method="post" action="/pass?id=<?= $t_id?>&name=<?= $t_name?>" enctype="multipart/form-data">
            <div class="quest">
                <h2>Question: <?= $question['q_text']?></h2>
                <?php foreach ($pictures as $picture):?>
                    <div class="picture">
                        <img src="<?= $picture['url']?>" style="width: 200px;">
                    </div>
                <?php endforeach;?>

                <?php foreach ($answers as $answer):?>
                    <div class="answer">
                        <input type="checkbox" name="<?= $answer['a_id']?>">
                        <span><?= $answer['a_text']?></span>
                    </div>
                <?php endforeach;?>
            </div>
            <input type="hidden" name="q_order" value="<?= $q_order?>">
        <input type="hidden" name="question" value="<?= $question['q_id']?>">
        <div class="submit">
            <input type="submit" class="input" value="Ответить">
        </div>
    </form>
</div>
<?php require_once "partials/footer.view.php"?>
