<div class="row">
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Тема</th>
                    <th colspan="2">Дії</th>
                </tr>
                </thead>
                <tbody>
				<?= CycleRender::CreateTopic() ?>
                </tbody>
            </table>
        </div>
        <p>Додати нову тему: <a href="/topic?action=add" class="btn btn-success btn-sm" role="button"><i class="fa fa-plus"></i> Додати</a></p>
    </div>
    <div class="col-md-6">
		<?= $action ?>
    </div>
</div>