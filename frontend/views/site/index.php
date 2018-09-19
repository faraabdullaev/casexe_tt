<?php

/* @var $this yii\web\View */
$this->title = 'My Application';

$js = <<<JS
const HTTP_STATUS_OK = 200;

const PRIZE_TYPE_BONUS = 0;
const PRIZE_TYPE_GIFT = 1;
const PRIZE_TYPE_MONEY = 2;

const httpPost = function (actionUrl, data, success, error) {
    $.ajax({
        url: actionUrl,
        method: 'POST',
        data: data,
        error: error,
        success: success
    });
};

const httpGet = function (actionUrl, success, error) {
    $.ajax({
        url: actionUrl,
        method: 'GET',
        error: error,
        success: success
    });
};

const hideAllContainers = function() {
  $('#offer-gift, #loading, #prize').hide();
};

const loadingVisibility = function(show) {
  hideAllContainers();
  if (show)
      return $('#loading').show();
  $('#loading').hide();
};

function getLastPrize() {
  loadingVisibility(true);
  httpGet('/gift/index',
    function (prize) {
      loadingVisibility(false);
      showPrizeContainer(prize);
    },
    function (error) {
      if (error.status === HTTP_STATUS_OK) {
          loadingVisibility(false);
          showOfferContainer();
      }
    }
  );
}

function showOfferContainer() {
  $('#offer-gift').show();
}

function showPrizeContainer(prize) {
    var resultHtml =  '';
  if (prize.prize_type === PRIZE_TYPE_BONUS) {
    var template = $('script[data-template="bonus"]');
    var templateHtml = template.html();
    resultHtml = templateHtml.replace(/{{prize_value}}/g, prize.prize_value)
                             .replace(/{{id}}/g, prize.id);
  }
  
  $('#prize').html(resultHtml).show();
}

function onPlayNowButtonClick() {
    loadingVisibility(true);
    httpPost('/gift/index', {},
    function (prize) {
      loadingVisibility(false);
      showPrizeContainer(prize);
    },
    function (error) {
    }
  );
}

function refuse(prize_id) {
  if (!confirm('Are you sure?'))
      return;
  
  loadingVisibility(true);
    httpGet('/gift/refuse/' + prize_id,
    function (prize) {
      loadingVisibility(false);
      showOfferContainer();
    },
    function (error) {
    }
  );
}

function addToLoyalCard(prize_id) {
  
}

getLastPrize();
JS;

$this->registerJs($js, $this::POS_END);
?>

<div class="site-index">

    <div id="offer-gift">
        <div class="jumbotron">
            <h1>Lorem ipsum dolor sit amet!</h1>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur commodi, corporis cupiditate dicta
                dolorum expedita impedit iure quo ratione repudiandae sequi soluta tempore, tenetur. Aut est impedit
                quas rerum temporibus.
            </p>
            <p>Alias architecto, dolorem dolores eius excepturi facere totam! Distinctio doloribus ea earum eligendi
                excepturi fugit maxime, quas, similique tenetur totam voluptas voluptatem? Commodi earum facere itaque
                nemo sint? Aliquid, similique.
            </p>

            <br>
            <button class="btn btn-success" onclick="onPlayNowButtonClick()">Play now!</button>
        </div>
    </div>

    <div id="loading" class="text-center">
        <img src="/images/loading.gif" alt="">
    </div>

    <div id="prize"></div>
</div>


<script type="text/template" data-template="bonus">
    <h1>You win: {{prize_value}} bonus point!!!</h1>
    <button class="btn btn-success" onclick="addToLoyalCard({{id}})">Add to Loyal Card</button>
    <button class="btn btn-default" onclick="refuse({{id}})">Refuse</button>
</script>

<script type="text/template" data-template="gift"></script>

<script type="text/template" data-template="money"></script>
