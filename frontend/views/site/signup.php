<h3><b>Заповніть всі поля:</b></h3>
<h4 style="color: red"><?= $message ?></h4>
<form name="newuser" action="/signup" method="post" role="form" enctype="multipart/form-data">
    <div class="form-group<?= $name[ 'class' ] ?> col-md-6">
        <label class="control-label">Ім'я:</label>
        <input type="text" name="name" class="form-control" placeholder="Введіть ваше ім'я" value="<? if(isset($_SESSION['signup']['name'])) echo $_SESSION['signup']['name']; ?>">
        <h5 style="color: red"><?= $name[ 'message' ] ?></h5>
    </div>
    <div class="form-group<?= $surname[ 'class' ] ?> col-md-6">
        <label class="control-label">Фамілія:</label>
        <input type="text" name="surname" class="form-control" placeholder="Введіть вашу фамілію" value="<? if(isset($_SESSION['signup']['name'])) echo $_SESSION['signup']['surname']; ?>">
        <h5 style="color: red"><?= $surname[ 'message' ] ?></h5>
    </div>
    <div class="form-group<?= $email[ 'class' ] ?> col-md-6">
        <label class="control-label">Email:</label>
        <input type="email" name="email" class="form-control" placeholder="Введіть email" value="<? if(isset($_SESSION['signup']['name'])) echo $_SESSION['signup']['email']; ?>">
        <h5 style="color: red"><?= $email[ 'message' ] ?></h5>
    </div>
    <div class="form-group<?= $password[ 'class' ] ?> col-md-6">
        <label class="control-label">Пароль:</label>
        <input type="password" name="password" class="form-control" placeholder="Придумайте пароль" value="<? if(isset($_SESSION['signup']['name'])) echo $_SESSION['signup']['password']; ?>">
        <h5 style="color: red"><?= $password[ 'message' ] ?></h5>
    </div>
    <div class="form-group<?= $key[ 'class' ] ?> col-md-12">
        <label class="control-label">Реєстраційний код:</label>
        <input type="text" name="key" class="form-control" placeholder="Код, який вам дав викладач" value="<? if(isset($_SESSION['signup']['name'])) echo $_SESSION['signup']['key']; ?>">
        <h5 style="color: red"><?= $key[ 'message' ] ?></h5>
    </div>
    <div class="col-md-12">
        <input type="submit" name="submit" class="btn btn-success" value="Зареєструватись">
    </div>
</form>