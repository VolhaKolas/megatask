$(".questiondiv .anotherpicture").on("click", function () {
    var length = $(".questiondiv .wrapperpicture").length;
    var wrapperpicture = $(".questiondiv .wrapperpicture").eq(0).clone();
    var text = $(wrapperpicture).children().eq(0).children().eq(0).text();
    text = text.replace(/(\d+)/, length + 1);
    $(wrapperpicture).children().eq(0).children().eq(0).text(text);
    var name = length + 1;
    var inputFile = "<input type='file' class='image' name='image"+ name + "' accept='image/jpg,image/jpeg,image/gif,image/png' onchange='$(this).prev().prev().children().eq(0).val(this.files[0].name);'>";
    $(wrapperpicture).children().eq(3).remove();
    $(wrapperpicture).append(inputFile);
    $(wrapperpicture).children().eq(1).children().eq(0).val("");
    $(wrapperpicture).insertBefore($(this));
});

$(".questiondiv .anotheranswer").on("click", function () {
    var length = $(".questiondiv .wrapperanswer").length;
    var wrapperanswer = $(".questiondiv .wrapperanswer").eq(0).clone();
    var text = $(wrapperanswer).children().eq(0).children().eq(0).children().eq(0).text();
    text = text.replace(/(\d+)/, length + 1);
    $(wrapperanswer).children().eq(0).children().eq(0).children().eq(0).text(text);
    var attrNameInput = $(wrapperanswer).children().eq(1).children().eq(0).attr("name");
    attrNameInput = attrNameInput.replace(/(\d+)/, length + 1);
    $(wrapperanswer).children().eq(1).children().eq(0).attr("name", attrNameInput);
    var  attrNameCheckbox = $(wrapperanswer).children().eq(0).children().eq(0).children().eq(1).attr("name");
    attrNameCheckbox = attrNameCheckbox.replace(/(\d+)/, length + 1);
    $(wrapperanswer).children().eq(0).children().eq(0).children().eq(1).attr("name", attrNameCheckbox);
    $(wrapperanswer).children().eq(1).children().eq(0).val('');
    $(wrapperanswer).children().eq(0).children().eq(0).children().eq(1).prop("checked", false);
    $(wrapperanswer).insertBefore($(this));
});

function checkbox(checkbox) {
    var check = document.querySelectorAll(".questiondiv .wrapperanswer input[type='checkbox']");

    for(var i = 0; i < check.length; i++) {
        check[i].checked = '';
        if(check[i] == checkbox) {
            check[i].checked = 'checked';
            check[i].setAttribute('checked', 'checked');
        }
    }
}

$(".questiondiv2 .anotherpicture").on("click", function () {
    var length = $(".questiondiv2 .wrapperpicture").length;
    var wrapperpicture = $(".questiondiv2 .wrapperpicture").eq(0).clone();
    var text = $(wrapperpicture).children().eq(0).children().eq(0).text();
    text = text.replace(/(\d+)/, length + 1);
    $(wrapperpicture).children().eq(0).children().eq(0).text(text);
    var name = length + 1;
    var inputFile = "<input type='file' class='image' name='image"+ name + "' accept='image/jpg,image/jpeg,image/gif,image/png' onchange='$(this).prev().prev().children().eq(0).val(this.files[0].name);'>";
    $(wrapperpicture).children().eq(3).remove();
    $(wrapperpicture).append(inputFile);
    $(wrapperpicture).children().eq(1).children().eq(0).val("");
    $(wrapperpicture).insertBefore($(this));
});


$(".questiondiv2 .anotheranswer").on("click", function () {
    var length = $(".questiondiv2 .wrapperanswer").length;
    var wrapperanswer = $(".questiondiv2 .wrapperanswer").eq(0).clone();
    var text = $(wrapperanswer).children().eq(0).children().eq(0).children().eq(0).text();
    text = text.replace(/(\d+)/, length + 1);
    $(wrapperanswer).children().eq(0).children().eq(0).children().eq(0).text(text);
    var attrNameInput = $(wrapperanswer).children().eq(1).children().eq(0).attr("name");
    attrNameInput = attrNameInput.replace(/(\d+)/, length + 1);
    $(wrapperanswer).children().eq(1).children().eq(0).attr("name", attrNameInput);
    var  attrNameCheckbox = $(wrapperanswer).children().eq(0).children().eq(0).children().eq(1).attr("name");
    attrNameCheckbox = attrNameCheckbox.replace(/(\d+)/, length + 1);
    $(wrapperanswer).children().eq(0).children().eq(0).children().eq(1).attr("name", attrNameCheckbox);
    $(wrapperanswer).children().eq(1).children().eq(0).val('');
    $(wrapperanswer).children().eq(0).children().eq(0).children().eq(1).prop("checked", false);
    $(wrapperanswer).insertBefore($(this));
});

function checkboxtwo(checkbox) {
    var check = document.querySelectorAll(".questiondiv2 .wrapperanswer input[type='checkbox']");

    count = 0;
    for(var j = 0; j < check.length; j++) {
        if($(check[j]).prop('checked') == true) {
            count++;
        }
    }

    if(count == check.length) {
        $(checkbox).prop("checked", false);
    }
}

$(".testdiv .anotherquestion").on("click", function () {
    var length = $(".testdiv .question").length;
    var wrapperquestion = $(".testdiv .question").eq(0).clone();
    var text = $(wrapperquestion).children().eq(0).children().eq(0).children().eq(0).text();
    text = text.replace(/(\d+)/, length + 1);
    var name = "question" + (length + 1);
    var input = "<input type='text' name='" + name + "' class='input'>";
    $(wrapperquestion).children().eq(0).children().eq(0).children().eq(0).text(text);
    $(wrapperquestion).children().eq(0).children().eq(0).append(input);
    $(wrapperquestion).insertBefore($(this));
});


$(".testdiv .thresholds input[type='checkbox']").on("click", function () {
    var check = document.querySelectorAll(".testdiv .thresholds input[type='checkbox']");
    for(var i = 0; i < check.length; i++) {
        check[i].checked = '';
        if(check[i] == this) {
            check[i].checked = 'checked';
            check[i].setAttribute('checked', 'checked');
        }
    }
});

$(".testdiv .time input[type='checkbox']").on("click", function () {
    if(this.checked) {
        $(".testdiv .time input[type='text']").val("");
        $(".testdiv .time input[type='text']").prop("disabled", true);
    }
    else {
        $(".testdiv .time input[type='text']").prop("disabled", false);
    }
});

