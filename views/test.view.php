<?php require_once "partials/header.view.php"?>
<?php require_once "partials/mainnav.view.php"?>
    <div class="wrapper1">
        <?php require_once "partials/leftnav" . \Core\User::role() . ".view.php"?>
        <?php require_once "partials/message.view.php"?>
        <div class="testdiv">
            <form action="/test" method="post" enctype="multipart/form-data">
                <div class="label"><label>Название теста: </label></div>
                <input type="text" class="input" name="t_name">


                <div class="category">
                    <div class="wrapperquestion">
                        <div class="label">
                            <label><span>Подкатегория и категория: </span>
                                <select name="subcategory" class="input">
                                    <?php foreach ($subcategories as $subcategory): ?>
                                    <option><?= $subcategory['sub_name']?> (<?= $subcategory['ca_name']?>)</option>
                                    <?php endforeach;?>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="wrapperquestion">
                    <div class="label"><label><span>Показывать правильные ответы (по завершении теста): </span> <input type="checkbox" name="showanswer"> </label></div>
                </div>

                <div class="wrapperquestion">
                    <div class="label"><label><span>Не показывать итоговую оценку: </span> <input type="checkbox" name="result"> </label></div>
                </div>

                <div class="wrapperquestion">
                    <div class="label"><label><span>Не показывать вердикт: </span> <input type="checkbox" name="verdict"> </label></div>
                </div>

                <div class="thresholds">
                    <div class="wrapperquestion">
                        <div class="label"><label><span>Порог прохождения: </span><input type="text" name="threshold" class="input"> </label></div>
                    </div>
                    <div class="wrapperquestion">
                        <div class="label"><label><span>Количество верных ответов: </span> <input type="checkbox" name="quantity"> </label></div>
                    </div>
                    <div class="wrapperquestion">
                        <div class="label"><label><span>Процент верных ответов: </span> <input type="checkbox" name="percent"> </label></div>
                    </div>
                </div>


                <div class="time">
                    <div class="wrapperquestion">
                        <div class="label"><label><span>Время прохождения теста: </span><input type="text" name="answertime" class="input"> </label></div>
                    </div>
                    <div class="wrapperquestion">
                        <div class="label"><label><span>Использовать сумму времени ответов: </span> <input type="checkbox" name="sumtime"> </label></div>
                    </div>
                </div>

                <div class="question">
                    <div class="wrapperquestion">
                        <div class="label"><label><span>Введите номер вопроса 1: </span><input type="text" name="question1" class="input"> </label></div>
                    </div>
                </div>

                <div class="question">
                    <div class="wrapperquestion">
                        <div class="label"><label><span>Введите номер вопроса 2: </span><input type="text" name="question2" class="input"> </label></div>
                    </div>
                </div>

                <div class="question">
                    <div class="wrapperquestion">
                        <div class="label"><label><span>Введите номер вопроса 3: </span><input type="text" name="question3" class="input"> </label></div>
                    </div>
                </div>

                <div class="question">
                    <div class="wrapperquestion">
                        <div class="label"><label><span>Введите номер вопроса 4: </span><input type="text" name="question4" class="input"> </label></div>
                    </div>
                </div>

                <div class="question">
                    <div class="wrapperquestion">
                        <div class="label"><label><span>Введите номер вопроса 5: </span><input type="text" name="question5" class="input"> </label></div>
                    </div>
                </div>

                <div class="anotherquestion"><a href="#">Click to add another question</a></div>

                <input type="submit" class="input" value="Создать">
            </form>
        </div>
    </div>
<?php require_once "partials/footer.view.php"?>