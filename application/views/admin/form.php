

<form enctype="multipart/form-data" id="album_form" method="post" action="<?=base_url($this->module).'/'.$action?>">

    <?php foreach ($this->languages as $language):?>
        <div class="row col-md-12">
            <div class="col-md-1 form-group">
                <label><?=$language['title']?></label>
            </div>
            <div class="col-md-4 form-group">
                <label for="titles-<?=$language['id']?>" class="sr-only">Заголовок</label>
                <input type="text" class="form-control" id="titles-<?=$language['id']?>" name="texts[<?=$language['id']?>][title]" value="<?= isset($texts[$language['id']]) ? $texts[$language['id']]['title'] : ''?>" placeholder="Заголовок">
            </div>
            <div class="col-md-7 form-group">
                <label for="descriptions[<?=$language['id']?>]" class="sr-only">Описание</label>
                <textarea id="descriptions[<?=$language['id']?>]" class="form-control" name="texts[<?=$language['id']?>][description]" placeholder="Описание"><?= isset($texts[$language['id']]) ? $texts[$language['id']]['description'] : ''?></textarea>
            </div>
        </div>
    <?php endforeach;?>
    <div class="row col-md-12">
        <div class="col-md-1 form-group">
            <label for="breadcrumb">URL</label>
        </div>
        <div class="col-md-8 input-group">
            <span class="input-group-addon" id="sizing-addon1"><?=base_url('portfolio').'/'?></span>
            <input type="text" class="form-control" id="breadcrumb" name="breadcrumb" value="<?= isset($breadcrumb) ? $breadcrumb : ''?>" placeholder="URL">
        </div>
    </div>
    <div class="row col-md-12">
        <div class="col-md-2 form-group"><label for="option1">Цвет текста</label> </div>
        <div class="col-md-8 form-group">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary <?= (!isset($font_color) || $font_color == 'black') ? 'active' : ''?>">
                    <input type="radio" name="font_color" id="option2" value="black" autocomplete="off" <?= (!isset($font_color) || $font_color == 'black') ? 'checked="checked"' : ''?> > Черный
                </label>
                <label class="btn btn-primary <?= (isset($font_color) && $font_color == 'white') ? 'active' : ''?>">
                    <input type="radio" name="font_color" id="option1" autocomplete="off" value="white" <?= (isset($font_color) && $font_color == 'white') ? 'checked="checked"' : ''?>> Белый
                </label>
            </div>
        </div>
    </div>
    <div class="row col-md-12">
        <div class="col-md-2 form-group"><label for="active">Показывать на сайте</label> </div>
        <div class="col-md-8 form-group">
                <input type="checkbox" name="active" <?=isset($active) && $active ? 'checked="checked"' : ''?>>
        </div>
    </div>
    <b style="padding-left: 15px">Обложка</b>
    <div class="row col-md-12" style="margin-bottom: 50px">
        <div class="col-md-4">

            <div id="cover_preview_container" class="uploadify-queue-item cover_preview_container">

                <div class="cover_preview" id="cover_preview" style="
                    background: url(<?=$cover_path?>), 50% 50% no-repeat;
                    background-size: contain;
                    background-position: 50% 50% !important;
                    background-repeat: no-repeat !important;
                ">
                </div>
                <a href="javascript: void(0);" id="delete_cover" class="btn btn-danger <?=(!$cover && !preg_match("/assets\/images\/albums\/(\d*)\/main.png/", $cover_path, $output_array)) ? 'disabled' : ''?>">Удалить</a>
                <input type="file" id="albumCover" name="albumCover">
                <input type="text" id="uploaded_cover" name="uploaded_cover" hidden="hidden" value="<?=$cover?>">
                <input type="text" id="album_id" hidden="hidden" value="<?=isset($id) ? $id : ''?>">
            </div>
        </div>
    </div>
    <?php if(isset($id)):?>
        <div  class="row col-md-12">
            <div style="padding-left: 25px" class="col-md-3 form-group">
                <a href="<?=base_url().$this->module.'/photos/'.$id?>" class="btn btn-lg btn-primary" id="photos_button"><span class="glyphicon glyphicon-camera"></span> ФОТОГРАФИИ (<?=$photos?>) </a>
            </div>
        </div>
    <?php endif;?>
    <div class="row col-md-12" >
        <div class="form-group">
            <a href="<?=base_url($this->module)?>" class="btn btn-default">Назад</a>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </div>


</form>
