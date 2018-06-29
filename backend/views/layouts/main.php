<!DOCTYPE html>
<html lang="ua">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= $title ?></title>
	<link rel="shortcut icon" href="..\..\image\icon.png">

	<!-- Bootstrap core CSS-->
	<link href="..\vendor\bootstrap\css\bootstrap.min.css" rel="stylesheet">
	<!-- Custom fonts for this template-->
	<link href="..\vendor\font-awesome\css\font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Page level plugin CSS-->
	<link href="..\vendor\datatables\dataTables.bootstrap4.css" rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="..\frontend\css\sb-admin.css" rel="stylesheet">

    <link href="..\common\css\classform.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
	<a class="navbar-brand" href="/results">Периферійні пристрої</a>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
				<a class="nav-link" href="/results">
					<i class="fa fa-fw fa-home"></i>
					<span class="nav-link-text">Головна</span>
				</a>
			</li>
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
				<a class="nav-link" href="/charts">
					<i class="fa fa-fw fa-area-chart"></i>
					<span class="nav-link-text">Статистика</span>
				</a>
			</li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Topic">
                <a class="nav-link" href="/topic">
                    <i class="fa fa-fw fa-cogs"></i>
                    <span class="nav-link-text">Теми</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Test">
                <a class="nav-link" href="/test">
                    <i class="fa fa-fw fa-pencil-square-o"></i>
                    <span class="nav-link-text">Тести</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                <a class="nav-link" href="/answer">
                    <i class="fa fa-fw fa-stack-overflow"></i>
                    <span class="nav-link-text">Відповіді</span>
                </a>
            </li>
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
				<small>Розробив студент групи 3ОК1, Таран Назар, 2018</small>
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

    <script type="text/javascript" src="..\simplebox_util.js"></script>
    <script type="text/javascript">
        (function(){
            var boxes=[],els,i,l;
            if(document.querySelectorAll){
                els=document.querySelectorAll('a[rel=simplebox]');
                Box.getStyles('simplebox_css','simplebox.css');
                Box.getScripts('simplebox_js','simplebox.js',function(){
                    simplebox.init();
                    for(i=0,l=els.length;i<l;++i)
                        simplebox.start(els[i]);
                    simplebox.start('a[rel=simplebox_group]');
                });
            }
        })();</script>
</div>
</body>

</html>
