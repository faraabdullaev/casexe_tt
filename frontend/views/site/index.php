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
  var template = null;
  
  if (prize.prize_type === PRIZE_TYPE_BONUS) {
    template = $('script[data-template="bonus"]');
  }
  
  if (prize.prize_type === PRIZE_TYPE_MONEY) {
    template = $('script[data-template="money"]');
  }
  
  if (prize.prize_type === PRIZE_TYPE_GIFT) {
    template = $('script[data-template="gift"]');
  }
  
  if (!template)
      return;
  
  var templateHtml = template.html();
  var resultHtml =  '';
  resultHtml = templateHtml.replace(/{{prize_value}}/g, prize.prize_value)
                           .replace(/{{prize_type}}/g, prize.prize_type)
                           .replace(/{{gift_name}}/g, prize.gift ? prize.gift.name : '')
                           .replace(/{{id}}/g, prize.id);
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
    function () {
      loadingVisibility(false);
      showOfferContainer();
    },
    function (error) {}
  );
}

function accept(prize_id, prize_type) {
  if (prize_type === PRIZE_TYPE_MONEY) {
      alert('Make sure you\'ve added your bank account to profile!');
  }
  if (prize_type === PRIZE_TYPE_GIFT) {
      alert('Make sure you\'ve added your address to profile!');
  }
  
  loadingVisibility(true);

  httpGet('/gift/accept/' + prize_id,
    function (prize) {
      loadingVisibility(false);
      showOfferContainer();
    },
    function (error) {}
  );
}

function convertToBonus(prize_id) {
  if (!confirm('Are you sure?'))
    return;

  loadingVisibility(true);
  httpGet('/gift/convert/' + prize_id,
    function (prize) {
      loadingVisibility(false);
      showOfferContainer();
    },
    function (error) {
      loadingVisibility(false);
      $('#prize').show();
    }
  );
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
