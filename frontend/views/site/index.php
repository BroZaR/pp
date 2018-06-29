<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="utf-8">

    <title><?= $title ?></title>
    <link rel="shortcut icon" href="..\..\image\icon.png">

    <!-- Bootstrap -->
    <link href="..\frontend\css\bootstrap.min.css" rel="stylesheet">
    <link href="..\frontend\css\theme.css" rel="stylesheet">
</head>
<body>

<!-- Intro Header -->
<header class="intro">
    <div class="intro-body">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="brand-heading"><?= $title ?></h1>
                    <p class="intro-text">
                        Для початку роботи
                        <button name="btn" class="btn btn-default" data-toggle="modal" data-target="#login">Увійдіть
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Login Users -->
<div id="login" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content" style="color: #000">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">x</button>
                <h3 class="modal-title" align="center">Вхід</h3>
                <h5 class="modal-title" style="color: red"><?= $error[ 'message' ] ?></h5>
            </div>
            <div class="modal-body">
                <div class="conteiner">
                    <form name="login" class="form-signin" action="" method="post">
                        <div class="form-group<?= $error[ 'class' ] ?>">
                            <input type="email" name="email" id="inputEmail" class="form-control"
                                   placeholder="Email адрес" required autofocus>
                        </div>
                        <div class="form-group<?= $error[ 'class' ] ?>">
                            <input type="password" name="password" id="inputPassword" class="form-control"
                                   placeholder="Пароль" required>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" value="remember-me"> Запам'ятати мене
                        </div>
                        <button name="login" class="btn btn-lg btn-primary btn-block" type="submit">Війти</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                Також ви можите <a href="/signup" style="color: blue">Зареєструватись</a> | <a
                        href="/restoration_password" style="color: blue" align="right">Забули пароль?</a>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="..\frontend\js\jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="..\frontend\js\bootstrap.min.js"></script>
<!-- Plugin JavaScript -->
<script src="..\frontend\js\jquery.easing.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="..\frontend\js\theme.js"></script>
<?php
if ( $error[ 'class' ] == ' has-error' ) {
	echo "<script>$('#login').modal();</script>";
}
?>
</body>
</html>