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