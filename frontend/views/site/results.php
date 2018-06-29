<div class="row">
    <!-- Example DataTables Card-->
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Таблиця результатів тестування
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Тема</th>
                            <th>Результат</th>
                        </tr>
                        </thead>
                        <tbody>
						<?= CycleRender::CreateRowTable( $id_user ) ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Icon Cards-->
    <div class="col-md-6">
        <div class="mb-3">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-pie-chart"></i> Ваші відповіді
                </div>
                <div class="container-fluid mb-3">
                    <br>
					<?= CycleRender::CreateBlockAnswer( $id_user ) ?>
                </div>
            </div>
        </div>
    </div>
</div>
