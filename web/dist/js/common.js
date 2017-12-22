//D:\Web-Projects\innovatoria\__TMP\OC demo\admin\view\javascript\common.js
var baseUrl = 'http://dev.biling.bioprogramme.net/app_dev.php/';
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
    /*
        $.ajax({
            url: 'index.php?route=common/filemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id'),
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

        $(element).popover('hide', function() {
            $('.popover').remove();
        });*/
    });

    $('#button-clear').on('click', function() {
        $(this).parents('.image-widget').find('img').attr('src', 'img/no_image.jpg');
        $(this).parents('.image-widget').find('input').attr('value', '');
    });

});