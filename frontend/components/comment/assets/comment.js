
$(function() {
    // 评论
    $('form#comment-form').on('beforeSubmit', function(e) {
        var $form = $(this);
        if ($form.find("input[name='Comment[uid]']").val() == 0) {
            alerting({msg: '请先登陆'});
            return false;
        }
        
        var content = $('#comment-content').val();
        if ($.trim(content) === '') {
            alerting({msg: '评论内容不能为空'});
            return false;
        }
        
        $.ajax({
            url: $form.attr('action'),
            type: 'post',
            data: $form.serialize(),
            success: function(obj) {
                // do something
                $('#comment-content').val('');
                var data = obj.data;
                var str = '<li class="media">';
                str += '<div class="media-left">';
                str += '   <a href="#">';
                str += '  <img alt="' + data['nickname'] + '" src="' + data['avatar'] + '" class="media-object">';
                str += '   </a>';
                str += '</div>';
                str += '<div class="media-body">';
                str += '<h4 class="media-heading">' + data['nickname'] + ' <span>' + data['createtime'] + '</span></h4>';
                str += data['content'] + '                     </div>';
                str += '</li>';

                $('.comment_list ul').prepend(str);
            }
        });
    }).on('submit', function(e) {
        e.preventDefault();
    });

    // 回复
    $('form.reply_form').on('beforeSubmit', function(e) {
        var $form = $(this);
        if ($form.find("input[name='Comment[uid]']").val() == 0) {
            alerting({msg: '请先登陆'});
            return false;
        }

        if ($.trim($form.find('.reply_content').val()) === '') {
            alerting({msg: '回复内容不能为空'});
            return false;
        }        

        $.ajax({
            url: $form.attr('action'),
            type: 'post',
            data: $form.serialize(),
            success: function(obj) {
                // do something
                $('.reply_content').val('');
                var data = obj.data;
                var str = '<div class="media child-media">';
                str += ' <a href="#" class="pull-left">';
                str += '<img alt="' + data['nickname'] + '" src="' + data['avatar'] + '" class="media-object">';
                str += ' </a><div class="media-body">';
                str += '<h4 class="media-heading">' + data['nickname'] + '<span>' + data['createtime'] + '</span></h4>';
                str += data['content'] + '                        </div></div>';

                $form.parents('.reply').siblings('.to_reply').prepend(str);
            }
        });
    }).on('submit', function(e) {
        e.preventDefault();
    })

    $('.reply_btn').on('click', function() {
        var reply = $(this).next('.reply_form');
        if (reply.is(":visible")) {
            reply.hide();
        } else {
            reply.show();
        }
    });

});