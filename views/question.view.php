<?php require_once "partials/header.view.php"?>
<?php require_once "partials/mainnav.view.php"?>
<div class="wrapper1">
    <?php require_once "partials/leftnav" . \Core\User::role() . ".view.php"?>
    <?php require_once "partials/message.view.php"?>
    <div class="questiontype">Вопрос первого типа (с одним ответом)</div>
    <div class="questiondiv">
        <form action="/question1" method="post" enctype="multipart/form-data">
            <div class="label"><label>Question: </label></div>
            <textarea class="input" name="question"></textarea>

            <div class="wrapperpicture">
                <div class="label"><label>Picture-1: </label></div>
                <div class="wrapperinput" onclick="$(this).next().next().click();"><input type="text" class="input textinput"></div>
                <div class="browse" onclick="$(this).next().click();">Browse</div>
                <input type="file" name="image1" class="image" accept="image/jpg,image/jpeg,image/gif,image/png" onchange="$(this).prev().prev().children().eq(0).val(this.files[0].name);">
            </div>

            <div class="anotherpicture"><a href="#">Click to add another picture</a></div>

            <div class="wrapperanswer">
                <div class="label"><label><span>Answer-1:</span> (correct <input type="checkbox" name="checkbox1" onclick="checkbox(this)">) </label></div>
                <div class="wrapperinput"><input type="text" name="answer1" class="input"></div>
            </div>
            <div class="wrapperanswer">
                <div class="label"><label><span>Answer-2:</span> (correct <input type="checkbox" name="checkbox2" onclick="checkbox(this)">) </label></div>
                <div class="wrapperinput"><input type="text" class="input" name="answer2"></div>
            </div>
            <div class="wrapperanswer">
                <div class="label"><label><span>Answer-3:</span> (correct <input type="checkbox" name="checkbox3" onclick="checkbox(this)">) </label></div>
                <div class="wrapperinput"><input type="text" class="input" name="answer3"></div>
            </div>
            <div class="wrapperanswer">
                <div class="label"><label><span>Answer-4:</span> (correct <input type="checkbox" name="checkbox4" onclick="checkbox(this)">) </label></div>
                <div class="wrapperinput"><input type="text" class="input" name="answer4"></div>
            </div>
            <div class="wrapperanswer">
                <div class="label"><label><span>Answer-5:</span> (correct <input type="checkbox" name="checkbox5" onclick="checkbox(this)">) </label></div>
                <div class="wrapperinput"><input type="text" class="input" name="answer5"></div>
            </div>

            <div class="anotheranswer"><a href="#">Click to add another answer</a></div>
            <input type="submit" class="input" value="Создать">
        </form>
    </div>
</div>
<?php require_once "partials/footer.view.php"?>