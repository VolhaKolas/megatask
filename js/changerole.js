$(".changerole").on("submit", function (event) {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "changerole",
        dataType: "JSON",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            if(1 != data.message) {
                $(".message").text(data.message);
            }
        }
    });
});
