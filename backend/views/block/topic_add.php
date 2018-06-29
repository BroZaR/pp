<div class="card border-primary mb-3">
    <div class="card-header">Додати нову тему</div>
    <div class="card-body">
        <form name="" action="/topic?action=add" method="post" role="form" enctype="multipart/form-data" class="col-md-8">
            <div class="form-group">
                <div class="<?= $class ?>" role="alert"><?= $message ?></div>
                <label class="control-label"><b>Назва теми: </b></label>
                <input type="text" name="topic" class="form-control" placeholder="Введіть назву теми">
            </div>
            <div class="form-group">
                <input type="submit" name="add" class="btn btn-success" value="Додати">
            </div>
        </form>
    </div>
</div>