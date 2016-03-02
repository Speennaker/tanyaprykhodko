

<form enctype="multipart/form-data" id="album_form" method="post" action="<?=base_url($this->module).'/password_change'?>">

    <div class="row col-md-12">
        <div class="col-md-4 form-group">
            <label for="breadcrumb">Текущий Пароль</label>
        </div>
        <div class="col-md-8 input-group form-group <?= array_key_exists('pword', $errors) ? 'has-error' : ''?>">
            <input type="password" class="form-control" name="pword" placeholder="Введите текущий пароль" required>
        </div>
    </div>
    <div class="row col-md-12">
        <div class="col-md-4 form-group">
            <label for="breadcrumb">Новый Пароль<br><small class="text-muted">от 5 до 20 символов</small> </label>
        </div>
        <div class="col-md-8 input-group form-group <?= array_key_exists('pword_new', $errors) ? 'has-error' : ''?>">
            <input type="password" class="form-control" name="pword_new" placeholder="Введите новый пароль" maxlength="20" pattern=".{5,20}" required>
        </div>
    </div>
    <div class="row col-md-12">
        <div class="col-md-4 form-group">
            <label for="breadcrumb">Подтверждение Нового Пароля</label>
        </div>
        <div class="col-md-8 input-group form-group <?= array_key_exists('pword_new_confirm', $errors) ? 'has-error' : ''?>">
            <input type="password" class="form-control" name="pword_new_confirm" placeholder="Введите подтверждение нового пароля" maxlength="20" pattern=".{5,20}" required>
        </div>
    </div>
    <div class="row col-md-12" >
        <div class="form-group">
            <a href="<?=base_url($this->module)?>" class="btn btn-default">Назад</a>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </div>


</form>
