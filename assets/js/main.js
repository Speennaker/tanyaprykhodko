$(document).ready(function () {

    $(document).on('click', '.disabled, .disabled a', function(e){
        e.preventDefault();
        return false;
    });

    $('[data-toggle="tooltip"]').tooltip({container: 'body'});
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

    $('#exampleInputFile').uploadify({
        'swf'      : base_url + 'assets/js/uploadify/uploadify.swf',
        'uploader' : base_url + 'categories/images_upload',
        'buttonClass' : 'btn btn-primary upload_button',
        'height' : 30,
        'buttonText' : 'BROWSE...',
        'progressData' : 'percentage',
        //'onUploadProgress' : function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
        //    $('#progress').html(totalBytesUploaded + 'bytes.');
        //},
        'itemTemplate' : '\
                    <div id="${fileID}" class="uploadify-queue-item preview_container">\
                        <a type="button" href="javascript:$(\'#${instanceID}\').uploadify(\'cancel\', \'${fileID}\')" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></a>\
                        <div class="preview">\
                        </div>\
                        <span class="fileName">${fileName} <br>(${fileSize})</span><br><span class="data">Loading...</span>\
                        <div class="uploadify-progress"><div class="uploadify-progress-bar"><!--Progress Bar--></div></div>\
                    </div>\
                ',
        'removeCompleted' : false,
        'onUploadComplete' : function(file) {
            var path = base_url + 'assets/uploads/' + file.name;
            $('#' + file.id + ' div.preview').css('background', 'url("' + path +'") 50% 50% no-repeat').css('background-size', 'contain');
        }



        // Put your options here
    });
    $('#albumCover').uploadify({
        'swf'      : base_url + 'assets/js/uploadify/uploadify.swf',
        'uploader' : base_url + 'admin/images_upload/cover',
        'buttonClass' : 'btn btn-primary',
        'height' : 30,
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

    //$(document).on('click', '#delete_cover', function(event){
    //
    //    event.preventDefault();
    //
    //
    //    deleteCover(id, $(this));
    //});
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