<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-sm-8">
            <h3><b><?= $topic ?></b></h3>
        </div>
        <div style="float: right; position: fixed; top: 70px; right: 20px; background: white;">
            <div id="clockdiv">
                <span class="minutes"></span>
                :
                <span class="seconds"></span>
            </div>
        </div>
    </div>
    <hr>
    <form name="test" action="<?= $_SERVER[ 'REQUEST_URI' ] ?>" method="post" role="form">
		<?= CycleRender::CreateTest( $tests ) ?>
        <p align="right"><input type="submit" name="submit" class="btn btn-success" value="Здати тест"></p>
    </form>
</div>
<script>
    function getTimeRemaining(endtime) {
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        return {
            'total': t,
            'minutes': minutes,
            'seconds': seconds
        };
    }

    function initializeClock(id, endtime) {
        var clock = document.getElementById(id);
        var minutesSpan = clock.querySelector('.minutes');
        var secondsSpan = clock.querySelector('.seconds');

        function updateClock() {
            var t = getTimeRemaining(endtime);

            minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
            secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

            if (t.total <= 0) {
                clearInterval(timeinterval);
            }
        }

        updateClock();
        var timeinterval = setInterval(updateClock, 1000);
    }

    var deadline = "January 01 2018 00:00:00 GMT+0300"; //for Ukraine
    var deadline = new Date(Date.parse(new Date()) + 20 * 60 * 1000); // for endless timer
    initializeClock('clockdiv', deadline);
</script>