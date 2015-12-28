<div class="container" style="padding-top: 200px">
    <div class="row col-md-12">
        <h2 style="font-size: 36px; width: 100%; text-align: center; padding-bottom: 20px" class="text-danger"><span class="glyphicon glyphicon-warning-sign"></span> Authorization needed</h2>
        <?php foreach($this->session->flashdata() as $class => $message):?>
            <div class="alert alert-<?=$class?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?=$message['text']?>
            </div>
        <?php endforeach;?>
        <div class="well center-block">
            <form method="post" action="<?=base_url($this->module)?>">

                <div class="form-group <?= array_key_exists('login', $errors) ? 'has-error' : '' ?>">
                    <input name="login" class="form-control" id="login" placeholder="Login" value="<?=$login?>">
                </div>
                <div class="form-group <?= array_key_exists('pword', $errors) ? 'has-error' : '' ?>">
                    <input type="password" class="form-control" id="pword" name="pword" placeholder="Password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>

        </div>
    </div>
</div>
