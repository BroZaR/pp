<div class="card border-secondary mb-3">
	<div class="card-header">
        <div class="row" >
	        <?= $header ?> /
            Варіант <?= $option ?>
            <a href="/test?action=delete&id=<?= $id ?>" style="position: absolute; right: 5px; color: #ccc; size: 20px;"><i class="fa fa-fw fa-times"></i></a>
        </div>
    </div>
	<div class="card-body">
		<?= $body ?>
        <a href="/testedit?action=edit&id=<?= $id ?>" class="btn btn-success" style="float: right">Редагувати <i class="fa fa-chevron-right"></i></a>
	</div>
</div>