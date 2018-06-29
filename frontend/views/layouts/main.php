<!DOCTYPE html>
<html lang="ua">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="..\..\image\icon.png">

    <style>
        #clockdiv{
            font-family: sans-serif;
            color: #000;
            display: inline-block;
            text-align: center;
            font-size: 40px;
        }

        #clockdiv > div{
            padding: 0px;
            border-radius: 0px;
            display: inline-block;
        }
    </style>

    <!-- Bootstrap core CSS-->
    <link href="..\vendor\bootstrap\css\bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="..\vendor\font-awesome\css\font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="..\vendor\datatables\dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="..\frontend\css\sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="/results">Периферійні пристрої</a>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="/results">
                    <i class="fa fa-home"></i>
                    <span class="nav-link-text">Головна</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <h6 style="color: #8cacb4; margin-left: 1em; margin-bottom: 0px;">
                    <span class="nav-link-text">Виберіть тему: </span>
                </h6>
            </li>
			<?= CycleRender::CreateMemu() ?>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="/results" class="nav-link">
                    <i class="fa fa-user-circle-o"></i> <?= $username ?></a>
            </li>
            <li class="nav-item">
                <a href="/exit" class="nav-link">
                    <i class="fa fa-fw fa-sign-out"></i>Вийти</a>
            </li>
        </ul>
    </div>
</nav>
<div class="content-wrapper">
    <div class="container-fluid">
	    <?= $content ?>
    </div>

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>Розробив студент групи 3ОК1, Таран Назар</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript-->
    <script src="..\vendor\jquery\jquery.min.js"></script>
    <script src="..\vendor\bootstrap\js\bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="..\vendor\jquery-easing\jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="..\vendor\chart.js\Chart.min.js"></script>
    <script src="..\vendor\datatables\jquery.dataTables.js"></script>
    <script src="..\vendor\datatables\dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="..\frontend\js\sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="..\frontend\js\sb-admin-datatables.min.js"></script>
    <script src="..\frontend\js\sb-admin-charts.min.js"></script>
</div>
</body>

</html>
