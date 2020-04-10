// $(".select2-selection__rendered").on("DOMSubtreeModified", function () {
//     $('.select2-selection__rendered li').each(function()
//     {
//         alert($(this).attr('title')); // This is your rel value
//     });
// });

$(".update-post-class").on("click", function (event) {
    var idPost = $(this).attr('data-input-id');
    var labelPostValue = $('#input_label_' + idPost).val();
    var labelPostValueEn = $('#input_label_en_' + idPost).val();

    $.ajax({
        url: Routing.generate('update.post', {
            idPost: idPost
        }),
        type: 'POST',
        async: true,
        data: {
            "value": labelPostValue,
            "valueEn": labelPostValueEn,
        },
        success: function (data) {
            window.location.href = Routing.generate('show.post');
        },
        error: function () {
            console.log('error update post');
        }
    });
});

$(".update-skill-class").on("click", function (event) {
    var idSkill = $(this).attr('data-input-id');
    var labelSkillValue = $('#input_label_' + idSkill).val();
    var labelSkillValueEn = $('#input_label_en_' + idSkill).val();

    $.ajax({
        url: Routing.generate('update.skill', {
            idSkill: idSkill
        }),
        type: 'POST',
        async: true,
        data: {
            "value": labelSkillValue,
            "valueEn": labelSkillValueEn,
        },
        success: function (data) {
            window.location.href = Routing.generate('show.skill');
        },
        error: function () {
            console.log('error update post');
        }
    });
});