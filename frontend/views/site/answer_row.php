<div class="col-md-12 mb-3">
    <div class="card text-white <?= $class ?> o-hidden h-100">
        <div class="card-body">
            <div class="card-body-icon">
                <i class="<?= $icon ?>"></i>
            </div>
            <div class="mr-5">
                <h5><?= $topic ?></h5>
                <p><?= $message ?></p>
            </div>
        </div>
        <a class="card-footer text-white clearfix small z-1" href="<?= $link ?>">
            <span class="float-left">Дивитися відповіді</span>
            <span class="float-right">
            <i class="fa fa-angle-right"></i>
        </span>
        </a>
    </div>
</div>