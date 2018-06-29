<div class="card border-primary mb-3">
	<div class="card-header"><?= $title ?></div>
	<div class="card-body">
		<form name="" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" role="form" enctype="multipart/form-data" class="col-md-8">
			<div class="form-group">
				<div class="<?= $class ?>" role="alert"><?= $message ?></div>
				<label class="control-label"><b>Нова назва теми: </b></label>
				<input type="text" name="topic" class="form-control" placeholder="Введіть нову назву теми">
			</div>
			<div class="form-group">
				<input type="submit" name="edit" class="btn btn-success" value="Змінити">
			</div>
		</form>
	</div>
</div>