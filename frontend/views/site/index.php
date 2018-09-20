<?php
/* @var $this yii\web\View */

$app = Yii::$app;

$this->title = $app->name;

$this->registerJsFile($app->urlManager->baseUrl . '/js/main.js', [
        'depends' => 'yii\web\YiiAsset',
        'position' => $this::POS_END
]);
?>

<div class="site-index">

    <div id="offer-gift" style="display:none;">
        <div class="jumbotron">
            <h1>Lorem ipsum dolor sit amet!</h1>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur commodi, corporis cupiditate dicta
                dolorum expedita impedit iure quo ratione repudiandae sequi soluta tempore, tenetur. Aut est impedit
                quas rerum temporibus.
            </p>

            <br>
            <button class="btn btn-success" onclick="onPlayNowButtonClick()">Play now!</button>
        </div>
    </div>

    <div id="loading" class="text-center">
        <img src="<?= $app->urlManager->baseUrl ?>/images/loading.gif" alt="">
    </div>

    <div id="prize" style="display:none;"></div>
</div>


<script type="text/template" data-template="bonus">
    <h1>You've won: {{prize_value}} bonus point!!!</h1>
    <button class="btn btn-success" onclick="accept({{id}}, {{prize_type}})">Add to Loyal Card</button>
    <button class="btn btn-default" onclick="refuse({{id}})">Refuse</button>
</script>

<script type="text/template" data-template="gift">
    <h1>You've won GIFT: <b>{{gift_name}}</b> !!!</h1>
    <button class="btn btn-success" onclick="accept({{id}}, {{prize_type}})">Accept</button>
    <button class="btn btn-default" onclick="refuse({{id}})">Refuse</button>
</script>

<script type="text/template" data-template="money">
    <h1>You've won MONEY: <b>{{prize_value}}</b> $$$</h1>
    <button class="btn btn-success" onclick="accept({{id}}, {{prize_type}})">Sent to My Bank Account</button>
    <button class="btn btn-primary" onclick="convertToBonus({{id}})">Add to Loyal Card</button>
    <button class="btn btn-default" onclick="refuse({{id}})">Refuse</button>
</script>
