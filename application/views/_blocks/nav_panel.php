<nav class="b_page-nav_wrapper">
    <div class="b_page-nav navbar navbar-fixed-bottom is_shown">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"><?= lang('menu')?></button>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <nav class="b_page-nav_list navbar-left">
                    <ul>
                        <?php foreach($menus as $key => $menu):?>
                            <li <?=$key == $menu_item ? 'class="active"' : ''?>><a <?=$key == $menu_item ? 'class="is-active"' : ''?> href="<?=$menu['url']?>" <?=$menu['additional_params']?>><?=$menu['title']?></a></li>
                        <?php endforeach;?>
                    </ul>
                </nav>
                <div class="navbar-right text-right">
                    <div class="wrapper">
                        <a href="https://www.facebook.com/TanyaPrykhodkoPhotography/?fref=ts" target="_blank"><div class="social">&#62220;</div></a>
                        <a href="https://500px.com/tanyaprykhodko" target="_blank"><div class="social entypo-infinity"></div></a>
                        <a href="https://www.instagram.com/tanyas_angels_be_like/" target="_blank"><div class="social">&#xf32d;</div></a>
                    </div>
                    <ul class="langs">
                        <li <?= $this->current_language_short == 'en' ? 'class="is-active"' : ''?>><a href="<?=uri_string() ? base_url(uri_string()) : base_url('index')?>?l=english">EN</a></li>
                        <li <?= $this->current_language_short == 'ru' ? 'class="is-active"' : ''?>><a href="<?=uri_string() ? base_url(uri_string()) : base_url('index')?>?l=russian">RU</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>