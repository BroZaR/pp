<div class="col-md-8 mb-3">
	<div class="card text-white bg-primary o-hidden h-100">
		<div class="card-body">
			<div class="card-body-icon">
				<i class="fa fa-smile-o"></i>
			</div>
			<div class="mr-5"><h3><b>Тестування по темі:</b> <?= $topic ?></h3></div>
			<p>На тестування виділено 45 хвилин.
				Загальна кількість тестів у варіанті - 30.
				Якщо ви впевнені, що добре підготовлені та якщо хочите пройти тестування перейдіть далі.</p>
		</div>
		<a class="card-footer text-white clearfix small z-1" href="/test?topic=<?= $key_topic ?>"  style="font-size: 20px;">
			<span class="float-left">Пройти тестування</span>
			<span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
		</a>
	</div>
</div>