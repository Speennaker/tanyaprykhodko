<?php
?>
<script>var defaultCover = "<?=base_url($this->default_cover)?>";</script>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= base_url()?>">Tanya Prykhodko</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <form class="navbar-form navbar-right">
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">Выйти</button>
                </div>
            </form>
        </div>
    </div>
</nav>
<div class="container admin_container">
    <?php if($breadcrumbs):?>
    <ol class="breadcrumb">
        <?php $current = array_pop($breadcrumbs);?>
        <?php foreach($breadcrumbs as $bc):?>
            <li><a href="<?=base_url('/').$bc['url']?>"><?=$bc['title']?></a></li>
        <?php endforeach;?>
        <li class="active"><?=$current['title']?></li>
    </ol>
    <?php endif;?>
    <?php foreach($this->messages as $message):?>
        <div class="alert alert-<?=$message['class']?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong><?=$message['title']?></strong> <?=$message['text']?>
        </div>
    <?php endforeach;?>
    <?php foreach($this->session->flashdata() as $class => $message):?>
        <div class="alert alert-<?=$class?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong><?=$message['title']?></strong> <?=$message['text']?>
        </div>
    <?php endforeach;?>
