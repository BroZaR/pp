<div class="row">
    <div class="col-md-8 col-sm-8 col-lg-9">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><?= $_SESSION[ 'topic' ] ?></li>
            <li class="breadcrumb-item active"><?= $sort ?></li>
        </ol>
		<?= CycleRender::CreateTest( $tests ) ?>
    </div>
    <div class="col-md-4 col-sm-4 col-lg-3">
        <div class="card bg-light mb-3" style="max-width: 40rem; ">
            <div class="card-body">
                <form name="topic_name" action="<?= $_SERVER[ 'REQUEST_URI' ] ?>" method="post" role="form"
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label">Виберіть тему: </label>
                        <select name="topic" class="form-control" onchange="this.form.submit()"
                                style="margin-right: 10px;">
                            <option value="0">Назва теми</option>
                            <option value="Всі теми">Всі теми</option>
							<?= CycleRender::COption( 'topic' , 'topic' ) ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Сортувати за: </label>
                        <select name="sortBy" class="form-control" onchange="this.form.submit()"
                                style="margin-right: 10px;">
                            <option value="0">Тип сортування</option>
                            <option value="problem">Назва тесту</option>
                            <option value="topic">Назва теми</option>
                            <option value="type">Тип тесту</option>
                            <option value="options">Варіант</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <a href="/testedit?action=add" class="btn btn-success" role="button"><i class="fa fa-plus"></i> Додати
                            тести</a></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div style="position:relative; left:50%; margin-left:-100px; width:200px;">
    <br>
    <?= CycleRender::CreatePagination($count_pages,$active) ?>
    <br>
</div>