$('.ui.dropdown').dropdown();

$('.ui.accordion').accordion();
$('.message .close').on('click', function () {
    $(this).closest('.message').transition('slide');
});
$('.myPost').contextmenu(function (e) {
    var post = $(this);
    post.find('.contextmenu').mousemove(function (e) {
        e.stopPropagation();
    }).css({
        'left': e.clientX + 'px',
        'top': e.clientY + 'px',
    }).addClass('openMenuAnimation');
    setTimeout(function () {
        post.find('.contextmenu').removeClass('openMenuAnimation')
    }, 200)
    post.find('.contextmenu .menu').css('display', 'block');
    return false;
});
var outMouse = false;
$('.myPost .contextmenu .menu').mousemove(function () {
    $(this).css('display', 'block');
    outMouse = false;
});
$(window).mousemove(function () {
    if (outMouse)
        $('.myPost .contextmenu .menu').fadeOut();
    setTimeout(function () {
        outMouse = true;
    }, 2000)
});


function checklengthpost(input) {
    if (input.val().trim().length > 255)
        $('.counter-post').css("color", "#e74c3c");
    else
        $('.counter-post').css("color", "#ccc");
    $('.counter-post span').html(input.val().trim().length)
}

if ($('.accordion [name=body]').length) {
    checklengthpost($('.accordion [name=body]'))
    $('.accordion [name=body]').on('input propertychange', function () {
        checklengthpost($(this))
    })
}

var CSRF_TOKEN = $('meta[name="something"]').attr('content');


$('.comments .trash').click(function () {
    var comm = $(this);
    $.ajax({
        url: '/comment/delete',
        type: "POST",
        data: {
            _token: CSRF_TOKEN,
            comment: comm.data('comment-delete')
        },
        success: function (data) {
            if (data.msg == 'Done') {
                comm.parentsUntil('.comments').fadeOut();
                $('.counter-comment').html(parseInt($('.counter-comment').html()) - 1);
            }
        }
    })
})


function resulteSearch(value) {
    $.ajax({
        url: "/search",
        type: 'get',
        data: {
            value: value
        },
        success: function (data) {
            var x = data.msg;
            $('.re').empty()
            $('.re').removeClass('visible');
            if (x != null) {
                $('.re').addClass('visible');
                for (var i = 0; i <= x.length - 1; i++) {
                    $(".re").append(
                        '    <a class="result" href="/profile/' + x[i]['name'] + '">\n' +
                        '                            <div class="content">\n' +
                        '                                <div class="title"><img style="border-radius: 50%; width: 2em; float: left; height: 2em;" class="ui image" src=/uploade/user/' + x[i]['image'] + '>&nbsp;' + x[i]['name'] + '</div>\n' +
                        '                            </div>\n' +
                        '                        </a>'
                    );
                }
            }
        },
    });
}

function notifications() {
    $.ajax({
        url: '/notifications',
        type: 'post',
        data: {
            _token: CSRF_TOKEN
        },
        success: function (data) {
            if (data.isLogin) {
                var not = data.notification,
                    user = data.user;
                $('.notifications .menu').empty();
                if (not.length) {
                    $('.notifications .counter').html(not.length);
                    $('.notifications .counter').fadeIn();
                    $.each(not, function (i) {
                        var content = user[i]['name'];
                        if (not[i]['type'] == 1)
                            content += " comment on your post";
                        else if (not[i]['type'] == 2)
                            content += " like your post";
                        var newItem = '<a href="/posts/' + not[i]['post_id'] + '" class="item"><img class="ui avatar image" src="/uploade/user/' + user[i]['image'] + '">' + content + '</a>';
                        $(newItem).appendTo('.notifications .menu');
                    })
                }
                else
                    $('.notifications .counter').fadeOut();
            }
        }
    })
};
notifications();
setInterval(notifications, 3000)

function copyText(textCopy) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(textCopy).select();
    document.execCommand("copy");
    $temp.remove();
}

// message type : negative  | positive
function messageController(messageContent, type) {
    $('.message').removeClass('hidden').addClass(type ? 'positive visible' : 'negative visible').removeClass(type ? 'negative' : 'positive').find('p').text(messageContent);
    setTimeout(function () {
        $('.message').closest('.message').transition('slide');
    }, 3000)
}

$('.copyTitle , .copyContent').click(function () {
    copyText($(this).data($(this).hasClass('copyTitle') ? 'title' : 'content'))
    $('.myPost .contextmenu .menu').fadeOut();
    messageController('Copy succeeded', true);
});

$('.deletePost').click(function () {
    $('.myPost .contextmenu .menu').fadeOut();
    var dataPost = $(this);
    $('.modal.deleteMsg').modal({
        onApprove: function () {
            $.ajax({
                url: '/posts/delete',
                type: 'post',
                data: {
                    _token: CSRF_TOKEN,
                    post: dataPost.data('postnumper')
                },
                success: function (data) {
                    if (data.msg) {
                        messageController('remove post succeeded', true);
                        $('#countPostInMaster').text(Number($('#countPostInMaster').text()) - 1);
                        dataPost.parentsUntil('.myPost').parent().remove()
                    } else if (!data.msg) {
                        messageController('remove post failed', false);
                    }
                }
            })
        }
    }).modal('show');
});