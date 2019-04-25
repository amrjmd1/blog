$('.comments.icon').click(function () {
    $('[name=body]').focus()
});
$('[name=body]').bind('keypress', function (e) {
    var input = $(this);
    if (e.keyCode == 13) {
        $.ajax({
            url: '/comment',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                body: input.val(),
                post_id: $('[name=post]').val(),
            },
            success: function (data) {
                if (data.msg == 'Done') {
                    input.val('')
                    console.log(data.comment)
                } else if (data.msg == 'empty')
                    input.addClass('emptyError')
            }
        })
    } else {
        input.removeClass('emptyError')
    }
})

function like() {
    $.ajax({
        url: '/like',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            user: $('[name=user]').val(),
            post_id: $('[name=post]').val()
        },
        success: function (data) {

            if (data.msg == true) {
                $('.likePost').html(parseInt($('.likePost').html()) + 1)
                $('.icpo').addClass('red');
            } else if (data.msg == false) {
                $('.likePost').html(parseInt($('.likePost').html()) - 1)
                $('.icpo').removeClass('red');
            } else
                console.log(data['msg'])
        }
    })
}