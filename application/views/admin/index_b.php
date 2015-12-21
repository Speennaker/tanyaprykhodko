

    <div class="table-responsive">
        <!--        --><?php //$this->load->view('_blocks/bulk_actions', ['actions' => $this->bulk_actions], false);?>
        <table class="table table-striped">
            <thead>
            <tr>
                <?php if(isset($this->bulk_actions) && $this->bulk_actions):?><th><input type="checkbox" id="mark_all_checkbox" value="1"></th><?php endif;?>
                <th>Заголовок</th>
                <th>Количество фотографий</th>
                <th>Показывать на сайте</th>
                <th width="200">
                    <a href="<?=base_url().$this->module.'/create'?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Создать Альбом">
                        <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&#9;Создать Альбом
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $row):?>
                <tr>
                    <?php if(isset($this->bulk_actions) && $this->bulk_actions):?><td><input type="checkbox" class="table_checkbox" data-id="<?=$row['id']?>" value="1"></td><?php endif;?>
                    <td><?=$row['title']?></td>
                    <td><?=$row['photos']?></td>
                    <td><input type="checkbox" <?=$row['active'] ? "checked" : ""?> disabled value="1"></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="...">
                            <a href="<?=base_url().$this->module.'/edit/'.$row['id']?>" type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Редактировать Альбом">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            </a>
                            <a type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Удалить Альбом">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php $this->load->view('_blocks/pagination', ['url' => 'admin', 'page' => $page, 'pages' => $pages], false);?>
    </div>
</div>
