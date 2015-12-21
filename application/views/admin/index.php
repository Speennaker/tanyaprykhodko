

   <div class="row col-xs-12">
       <?php foreach($list as $row):?>
           <div class="col-xs-4">
               <div class="admin_album <?=!$row['active'] ? 'unactive_album' : ''?>" style="background: url('<?=$row['cover']?>') 50% 50% no-repeat;">
                   <div class="btn-group pull-right" role="group" aria-la Bel="...">
                       <a type="button" class="btn btn-toolbar" data-toggle="tooltip" data-placement="top" title="Показывать\Не показывать">
                           <span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span>
                       </a>
                       <a href="<?=base_url().$this->module.'/edit/'.$row['id']?>" type="button" class="btn btn-toolbar" data-toggle="tooltip" data-placement="top" title="Редактировать Альбом">
                           <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                       </a>
                       <a type="button" class="btn btn-toolbar" data-toggle="tooltip" data-placement="top" title="Удалить Альбом">
                           <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                       </a>
                   </div>
                   <span class="album_title center-block white"><?=$row['texts'][1]['title']?></span>
                   <span class="album_description center-block white"><?=$row['texts'][1]['description']?></span>

               </div>

           </div>
       <?php endforeach;?>
       <div class="col-xs-4">
           <div class="admin_album" style="background: url('https://placeholdit.imgix.net/~text?txtsize=33&txt=%D0%94%D0%BE%D0%B1%D0%B0%D0%B2%D0%B8%D1%82%D1%8C%20%D0%90%D0%BB%D1%8C%D0%B1%D0%BE%D0%BC&w=270&h=228') 50% 50% no-repeat;">

           </div>

       </div>





   </div>


</div>
