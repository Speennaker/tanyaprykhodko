
    <script>var albumId = <?=$album['id']?></script>
    <div class="row col-xs-12" id="photos_container">
            <div id="no_photos" class="alert alert-warning" <?= $list ? 'hidden="hidden"' : ''?>>Нет фотографий</div>
        <?php foreach($list as $filename => $file_path):?>
            <div class="col-xs-3">
                <div class="uploadify-queue-item photo_preview_container">
                    <a type="button" href="javascript:void(0);" data-filename="<?=$filename?>" class="close delete_photo" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                    <div class="photo_preview" style="
                        background: url(<?=$file_path?>), 50% 50% no-repeat;
                        background-size: contain;
                        background-position: 50% 0 !important;
                        background-repeat: no-repeat !important;
                        ">
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="row col-md-12" >
        <div class="col-md-2 form-group">
            <input type="file" id="uploadPhotos">
        </div>
    </div>
    <div class="row col-md-12" >
        <div class="form-group">
            <a href="<?=base_url($this->module)?>" class="btn btn-default">Альбомы</a>
            <a href="<?=base_url($this->module.'/edit/'.$album['id'])?>" class="btn btn-success">Редактировать Альбом</a>
        </div>
    </div>

