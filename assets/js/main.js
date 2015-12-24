$(document).ready(function () {

    $(document).on('click', '.disabled, .disabled a', function(e){
        e.preventDefault();
        return false;
    });

    $('[data-toggle="tooltip"]').tooltip({container: 'body', animation: false});
    $(document).on('change', '.table_checkbox', function(){
        var others = $('.table_checkbox:checked').length;
        dropdownToggle (others);
    });

    $(document).on('change', '#mark_all_checkbox', function(){
        var table_checkboxes = $('.table_checkbox');
        var state = $(this).prop('checked');
        table_checkboxes.prop('checked', state);
        dropdownToggle(state);
    });

    $(document).on('click', '.delete_photo', function(){
        deletePhoto($(this));
    });

    $(document).on('click', '#bulk_actions_list a, #deleteConfirmed', function(){
        var url = $(this).data('url');
        if(url.indexOf('delete') > 1 && $(this).id != 'deleteConfirmed')
        {
            deleteConfirmation(url);
            return false;
        }
        $('.modal').modal('hide');
        // AJAX!

        location.reload(true);
    });
    $(document).on('keyup', '#titles-2', function(){
        generateBreadcrumb(this)
    });

    if(typeof albumId !=="undefined")
    {
        $('#uploadPhotos').uploadify({
            'swf'      : base_url + 'assets/js/uploadify/uploadify.swf',
            'uploader' : base_url + 'index/photos_upload/'+albumId,
            'buttonClass' : 'btn btn-primary btn-lg upload_button',
            'height' : 30,
            'fileTypeDesc' : 'Image Files',
            'fileTypeExts' : '*.gif; *.jpg; *.png; *.jpeg; *.bmp',
            'buttonText' : 'Загрузить',
            'progressData' : 'percentage',
            'onUploadStart' : function(file) {
                var block  = '\
             <div class="col-xs-3">\
                <div id="file-'+ file.id+'" class="uploadify-queue-item photo_preview_container">\
                    <a type="button" href="javascript:void(0);" class="close delete_photo" aria-label="Close"><span aria-hidden="true">&times;</span></a>\
                    <div class="photo_preview">\
                </div>\
                <div class="progress">\
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">\
            0%\
            </div>\
            </div>\
                </div>\
            </div>\
                ';
                $('#no_photos').hide();
                $('#photos_container').append(block);

            },

            'onUploadProgress' : function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
                var percents = parseInt(bytesUploaded/(bytesTotal / 100));
                $('#file-'+ file.id+' .progress-bar').html(percents +'%').css('width', percents +'%');
            },
            'itemTemplate' : '<div id="${fileID}" class="uploadify_template">Загружаю...</div>',
            'removeCompleted' : true,
            'onUploadSuccess' : function(file, data, response) {
                if(data == 'FALSE')
                {
                    $('#file-' + file.id + ' div.photo_preview').parents('.col-xs-3').remove();
                }
                var path = base_url + 'assets/images/albums/'+albumId+ '/' + data;
                $('#file-' + file.id + ' div.photo_preview').css('background', 'url("' + path +'") 50% 0 no-repeat').css('background-size', 'contain');
                $('#file-' + file.id + ' a.delete_photo').attr('data-filename', data);
                $('#file-'+ file.id+' .progress').remove();

            }



            // Put your options here
        });
    }

    $('#albumCover').uploadify({
        'swf'      : base_url + 'assets/js/uploadify/uploadify.swf',
        'uploader' : base_url + 'index/images_upload/cover',
        'buttonClass' : 'btn btn-primary',
        'height' : 30,
        'fileTypeDesc' : 'Image Files',
        'fileTypeExts' : '*.gif; *.jpg; *.png; *.jpeg; *.bmp',
        'buttonText' : 'Загрузить',
        'progressData' : 'percentage',
        'multi' : false,
        'removeCompleted' : true,
        'onUploadStart': function(){$('.cover_preview').addClass('loading')},
        'onUploadComplete' : function(file) {
            var path = base_url + 'assets/uploads/' + file.name;
            $('.cover_preview').removeClass('loading');
            $('.cover_preview').css('background', 'url("' + path +'") 50% 50% no-repeat').css('background-size', 'contain');
            $('#uploaded_cover').attr('value', file.name);
            $('#delete_cover').removeClass('disabled');
            $('#delete_cover').removeAttr('disabled');
        }



        // Put your options here
    });

    $(document).on('click', '.album_status', function(event){

        event.preventDefault();

        updateAlbumStatus($(this));
    });

    $("#delete_cover").confirm({
        text: "Вы уверены что хотите удалить обложку?",
        title: "Требуется подтверждение",
        confirm: function(button) {
            var id = $('#album_id').val();
            deleteCover(id, button);
        },
        cancel: function(button) {
            // nothing to do
        },
        confirmButton: "Да",
        cancelButton: "Нет",
        post: true,
        confirmButtonClass: "btn-danger",
        cancelButtonClass: "btn-default",
        dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
    });

    $(".delete_album").confirm({
        text: "Вы уверены что хотите удалить альбом вместе со всеми фотографиями?",
        title: "Требуется подтверждение",
        confirm: function(button) {
            var id = button.data('id');

            var block = button.parents('.col-xs-4');
            deleteAlbum(id, block);
        },
        cancel: function(button) {
            // nothing to do
        },
        confirmButton: "Да",
        cancelButton: "Нет",
        post: true,
        confirmButtonClass: "btn-danger",
        cancelButtonClass: "btn-default",
        dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
    });


    if($(".b_sections-container").length)
    {
        var blockScroller =  $(".b_sections-container").blockScroll({
            scrollDuration:400,
            fadeBlocks: false,
            fadeDuration: 200
        });


        $('.b_page-nav_list a').bind('click', function(e){
            e.preventDefault();
            var n = $(this).data('href');
            blockScroller.goto([n]);
        });
    }


});


function dropdownToggle(state)
{
    var dropdown = $('#bulk_actions');
    if(state)
    {
        dropdown.removeClass('disabled');
    }
    else
    {
        dropdown.addClass('disabled');
    }
}

function deleteConfirmation(url)
{
    var modal = $('#confirmationModal');
    $('#deleteConfirm').data('url', url);
    $(modal).modal();
}

function generateBreadcrumb(input)
{
    var val = $(input).val();
    if(val.length == 0) return false;
    var breadcrumbInput = $('#breadcrumb');
    breadcrumbInput.val(val.replace(/ /g, '_').toLowerCase());
}

function deleteCover(id, button)
{
    var preview = $('.cover_preview');
    if(id)
    {
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/ajax_delete_cover',
            data: {id: id},

            beforeSend: function(){
                preview.addClass('loading');
            },
            success: function(response){
                preview.removeClass('loading');
                if (response != "FALSE")
                {
                    preview.css('background-image', 'url("' + defaultCover +'")');
                }
                else if(response == "FALSE")
                {

                }
            }
        });
    }

    $('#uploaded_cover').attr('value', '');
    button.addClass('disabled');
    button.attr('disabled', 'disabled');

}

function deleteAlbum(id, block)
{
    if(id)
    {
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/ajax_delete_album',
            data: {id: id},

            beforeSend: function(){
                block.find('.admin_album').addClass('loading');
            },
            success: function(response){
                if (response != "FALSE")
                {
                    block.remove();
                }
                else if(response == "FALSE")
                {
                    block.removeClass('loading');
                }
            }
        });
    }
}

function updateAlbumStatus(button)
{
    var id = button.data('id');
    if(id)
    {
        var block = button.parents('.col-xs-4');
        var cover =  block.find('.admin_album');
        var status = 1;
        if(button.hasClass('glyphicon-check'))
        {
            status = 0;
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/ajax_update_album_status',
            data: {id: id, status:status},

            beforeSend: function(){
               cover.addClass('loading');
            },
            success: function(response){
                cover.removeClass('loading');
                if (response != "FALSE")
                {
                  if(status == 1)
                  {
                      button.removeClass('glyphicon-unchecked');
                      button.addClass('glyphicon-check');
                      cover.removeClass('unactive_album');
                  }
                    else
                  {
                      button.removeClass('glyphicon-check');
                      button.addClass('glyphicon-unchecked');
                      cover.addClass('unactive_album');
                  }

                }
                else if(response == "FALSE")
                {

                }
            }
        });
    }
}


function deletePhoto(button)
{
    var filename = button.data('filename');
    var block = button.parents('.col-xs-3');
    $.ajax({
        type: 'POST',
        url: base_url + 'admin/ajax_delete_photo',
        data: {album_id: albumId, filename: filename},

        beforeSend: function(){
            block.css('opacity', '0.3');
        },
        success: function(response){
            if (response != "FALSE")
            {
                block.remove();
                if(!$('.photo_preview_container').length)
                {
                    $('#no_photos').show();
                }
            }
            else if(response == "FALSE")
            {
                block.css('opacity', '1.0');
            }
        }
    });
}