

   <div class="row col-xs-12">
       <?php foreach($list as $row):?>
           <div class="col-xs-4">
               <div class="admin_album <?=!$row['active'] ? 'unactive_album' : ''?>" style="background: url('<?=$row['cover']?>') 50% 50% no-repeat; background-color: grey;">
                   <div class="btn-group pull-right <?=$row['font_color']?>" role="group" aria-label="...">
                       <a href="<?=base_url().'portfolio/'.$row['breadcrumb']?>" type="button" class="btn btn-toolbar" data-toggle="tooltip" data-placement="top" title="Просмотр Альбома">
                           <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                       </a>
                       <a href="<?=base_url().$this->module.'/photos/'.$row['id']?>" type="button" class="btn btn-toolbar" data-toggle="tooltip" data-placement="top" title="Фотографии (<?=$row['photos']?>)">
                           <span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
                       </a>
                       <a type="button" class="btn btn-toolbar" data-toggle="tooltip" data-placement="top" title="Показывать\Не показывать">
                           <span class="glyphicon glyphicon-<?=$row['active'] ? 'check' : 'unchecked'?> album_status" data-id="<?=$row['id']?>" aria-hidden="true"></span>
                       </a>
                       <a href="<?=base_url().$this->module.'/edit/'.$row['id']?>" type="button" class="btn btn-toolbar" data-toggle="tooltip" data-placement="top" title="Редактировать Альбом">
                           <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                       </a>
                       <a type="button" class="btn btn-toolbar" data-toggle="tooltip" data-placement="top" title="Удалить Альбом">
                           <span class="glyphicon glyphicon-remove delete_album" data-id="<?=$row['id']?>" aria-hidden="true"></span>
                       </a>
                   </div>
                   <span class="album_title center-block <?=$row['font_color']?>"><?=$row['texts'][1]['title']?></span>
<!--                   <span class="album_description center-block white">--><?//=$row['texts'][1]['description']?><!--</span>-->

               </div>

           </div>
       <?php endforeach;?>
       <div class="col-xs-4">
           <div class="admin_album" id="add_album">
               <a href="<?=base_url().$this->module.'/create'?>"></a>

           </div>

       </div>





   </div>


</div>
