<div class="container-fluid" style="margin-bottom: 13px;">
    <div class="row">
        <form name="results_years" action="/results" method="post" role="form" enctype="multipart/form-data"
              class="form-inline">
            <div class="form-group">
                <label class="sr-only">Навчальний рік: </label>
                <select name="years" class="form-control" onchange="this.form.submit()" style="margin-right: 10px;">
                    <option value="0">Навчальний рік</option>
					<?= CycleRender::COption( 'years' ) ?>
                </select>
            </div>
            <div class="form-group">
                <label class="sr-only">Група: </label>
                <select name="groups" class="form-control" onchange="this.form.submit()">
                    <option value="0">Група</option>
					<?= CycleRender::COption( 'groups' ) ?>
                </select>
            </div>
        </form>
    </div>
</div>
<p style="margin-left: 7px;"><?= CycleRender::Way() ?></p>
<div class="row">
    <!-- Example DataTables Card-->
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Таблиця результатів тестування
            </div>
            <div class="card-body">
                <div class="table-responsive">
					<?= CycleRender::CreateResultTable() ?>
                </div>
            </div>
        </div>
    </div>
</div>