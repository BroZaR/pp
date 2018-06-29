
<div class="container">
	<h3><b>Заповніть або замініть поля:</b></h3>
	<div class="<?= $class ?>" role="alert"><?= $message ?></div>
	<form name="testedit" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" role="form" enctype="multipart/form-data">
		<div class="row">
			<div class="form-group col-md-6 <?= $error['topic']['class'] ?>">
				<label class="control-label flabel">Тема:</label>
				<select name="topic" class="form-control form-input">
					<option value="0">Назва теми</option>
					<?= CycleRender::COption( 'topic' , 'topic', $value['topic'] ) ?>
				</select>
				<p class="form-message"><?= $error['topic']['message'] ?></p>
			</div>
			<div class="form-group col-md-6 <?= $error['problem']['class'] ?>">
				<label class="control-label flabel">Питання:</label>
				<input type="text" name="problem" class="form-control form-input" placeholder="Питання тесту" value="<?= $value['problem'] ?>">
				<p class="form-message"><?= $error['problem']['message'] ?></p>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 <?= $error['options']['class'] ?>">
				<label class="control-label">Варіант:</label>
				<input type="text" name="options" class="form-control form-input" placeholder="1" value="<?= $value['options'] ?>">
				<p class="form-message"><?= $error['options']['message'] ?></p>
			</div>
			<div class="form-group col-md-3 <?= $error['link']['class'] ?>">
				<label class="control-label">Зображення тесту:</label>
				<input type="file" name="file" class="form-control form-input" multiple accept="image/*">
				<p class="form-message"><?= $error['link']['message'] ?></p>
			</div>
			<div class="form-group col-md-3">
				<?= $img_edit ?>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6  <?= $error['right']['class'] ?>">
				<label class="control-label">Правильні варіанти відповіді(обов'язково вказати хоча б одну):</label>
				<input type="text" name="right_0" class="form-control form-input" placeholder="Правильний варіант відповіді" value="<? if(isset($value['right'][0])) echo $value['right'][0] ?>">
				<p class="form-message"></p>
				<input type="text" name="right_1" class="form-control form-edit form-input" placeholder="Правильний варіант відповіді" value="<? if(isset($value['right'][1])) echo $value['right'][1] ?>">
				<p class="form-message"></p>
				<input type="text" name="right_2" class="form-control form-edit form-input" placeholder="Правильний варіант відповіді" value="<? if(isset($value['right'][2])) echo $value['right'][2] ?>">
				<p class="form-message"></p>
				<input type="text" name="right_3" class="form-control form-edit form-input" placeholder="Правильний варіант відповіді" value="<? if(isset($value['right'][3])) echo $value['right'][3] ?>">
				<p class="form-message"></p>
				<input type="text" name="right_4" class="form-control form-edit form-input" placeholder="Правильний варіант відповіді" value="<? if(isset($value['right'][4])) echo $value['right'][4] ?>">
				<p class="form-message"><?= $error['right']['message'] ?></p>
			</div>
			<div class="form-group col-md-6  <?= $error['wrong']['class'] ?>">
				<label class="control-label">Неправильні варіанти відповіді:</label>
				<input type="text" name="wrong_0" class="form-control form-input" placeholder="Неправильний варіант відповіді" value="<? if(isset($value['wrong'][0])) echo $value['wrong'][0] ?>">
				<p class="form-message"></p>
				<input type="text" name="wrong_1" class="form-control form-edit form-input" placeholder="Неправильний варіант відповіді" value="<? if(isset($value['wrong'][1])) echo $value['wrong'][1] ?>">
				<p class="form-message"></p>
				<input type="text" name="wrong_2" class="form-control form-edit form-input" placeholder="Неправильний варіант відповіді" value="<? if(isset($value['wrong'][2])) echo $value['wrong'][2] ?>">
				<p class="form-message"></p>
				<input type="text" name="wrong_3" class="form-control form-edit form-input" placeholder="Неправильний варіант відповіді" value="<? if(isset($value['wrong'][3])) echo $value['wrong'][3] ?>">
				<p class="form-message"></p>
				<input type="text" name="wrong_4" class="form-control form-edit form-input" placeholder="Неправильний варіант відповіді" value="<? if(isset($value['wrong'][4])) echo $value['wrong'][4] ?>">
				<p class="form-message"><?= $error['wrong']['message'] ?></p>
			</div>
		</div>
		<div class="col-md-12">
			<input type="submit" name="submit" class="btn btn-success" value="Зберегти">
		</div>
	</form>
</div>