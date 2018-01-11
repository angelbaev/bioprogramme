$(document).ready(function() {
    $('#button-image').on('click', function() {
        $('#modal-image').remove();
        var target = $(this).parents('.image-widget').find('input').attr('id');
        var thumb = $(this).parents('.image-widget').find('img').attr('id');
        $.ajax({
            url: baseUrl + 'image-manager?target=' + target + '&thumb=' + thumb,
            dataType: 'html',
            beforeSend: function() {
                $('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
                $('#button-image').prop('disabled', true);
            },
            complete: function() {
                $('#button-image i').replaceWith('<i class="fa fa-pencil"></i>');
                $('#button-image').prop('disabled', false);
            },
            success: function(html) {
                $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                $('#modal-image').modal('show');
            }
        });
    });

    $('#button-clear').on('click', function() {
        $(this).parents('.image-widget').find('img').attr('src', 'img/no_image.jpg');
        $(this).parents('.image-widget').find('input').attr('value', '');
    });

    $('.select2').select2();
    //bootstrap WYSIHTML5 - text editor
    $('.wysihtml').wysihtml5();
});

//https://github.com/willdurand/BazingaJsTranslationBundle
var CustomerEventSource = /** @class */ (function () {

    function CustomerEventSource() {
    }

    CustomerEventSource.notificationEventHandler = function () {
        var source = new EventSource(baseUrl + 'notification');
        source.onmessage = function(event) {
            var data = JSON.parse(event.data);
            // notifications
            $('#notification_count').html(data.notifications.length);
            if (data.notifications.length === 0) {
                $('#notification_count').hide();
            } else {
                $('#notification_count').show();
            }
            $('#notification_list').html('');
            var html = '';
            for(var i in data.notifications) {
                var notification = data.notifications[i];
                html += '<li><a href="' + baseUrl + 'marketing/notification/' + notification.id + '"><i class="fa text-aqua"></i> ' + notification.message + '</a></li>';
            }
            if (html === '') {
                html += '<li><a href="javascript:;"><i class="fa text-aqua"></i> ' + translation['no_new_notifications'] + '</a></li>';
            }
            $('#notification_list').html(html);

            // emails
            $('#message_count').html(data.emails.length);
            if (data.emails.length === 0) {
                $('#message_count').hide();
            } else {
                $('#message_count').show();
            }
            $('#message_list').html('');
            var html = '';
            for(var i in data.emails) {
                var email = data.emails[i];
                html += '<li>'
                     + '<a href="' + baseUrl + 'marketing/email/' + email.id + '">'
                    + '<div class="pull-left">'
                    + '<img src="' + email.fromUser.image + '" class="img-circle" title="' + email.fromUser.fullName + '" alt="' + email.fromUser.fullName + '">'
                    + '</div>'
                    + '<h4>' + email.subject + '<small><i class="fa fa-clock-o"></i> ' + email.fromUser.fullName + '</small></h4>'
                     + '</a>'
                     + '</li>';
            }
            if (html === '') {
                html += '<li><a href="javascript:;"><i class="fa text-aqua"></i> ' + translation['no_new_messages'] + '</a></li>';
            }
            $('#message_list').html(html);
            //tasks
        };

        source.onopen = function() {
        };

        source.onerror = function(error) {
        };
    };

    CustomerEventSource.init = function () {
        if(typeof(EventSource) !== 'undefined') {
            CustomerEventSource.notificationEventHandler();
        } else {
            console.log('EventSource is not supported!');
        }
    };

    return CustomerEventSource;
}());