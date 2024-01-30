var INDEX = (function() {
    return function() {

        var minPriceElement, maxPriceElement, currency, conditionElement, actionElement, provinceElement, searchButton;
        var toggleDiv, specificDiv, conditionDiv, permutaElement, ventaElement, giveElement, wantElement;

        this.init = function() {
            toggleDiv = $('.toggle');
            specificDiv = $('#specific');
            specificDiv.hide();
            conditionDiv = $('#condition_s');
            permutaElement = $('.permuta');
            ventaElement = $('.venta');
            minPriceElement = $('#price-min');
            maxPriceElement = $('#price-max');
            currencyElement = $('#currency');
            conditionElement = $('#condition');
            conditionElement.change(changeCondition);
            giveElement = $('#give');
            wantElement = $('#want');
            actionElement = $('#action');
            actionElement.change(changeAction);
            provinceElement = $('#province');
            searchButton = $('#search-now');
            searchButton.click(search);
            changeAction();
            changeCondition();
        };

        var search = function(e) {
            var min = minPriceElement.val();
            var max = maxPriceElement.val();
            var currency = currencyElement.val();
            var province = provinceElement.val();
            var action = actionElement.val();
            var url = action + '/viviendas';

            if (province != 0)
                url += '/' + province;

            if (action == 'venta') {
                if (min != '' || max != '') {
                    if (!isNaN(min) && !isNaN(max) && parseInt(min) <= parseInt(max)) {
                        url += '?pricemin=' + min + '&pricemax=' + max
                    } else if (!isNaN(min) && (isNaN(max) || max == "")) {
                        url += '?pricemin=' + min
                    } else if (!isNaN(max) && (isNaN(min) || min == "")) {
                        url += '?pricemax=' + max
                    }

                    if (currency != '0') {
                        url += '&currency=' + currencyElement.val();
                    }
                } else if (currency != '0') {
                    url += '?currency=' + currencyElement.val();
                }

            } else if (action == 'permuta') {
                if (conditionElement.val() == 'user') {
                    if (!isNaN(giveElement.val()) && !isNaN(wantElement.val())) {
                        url += '?condition=' + giveElement.val() + 'x' + wantElement.val();
                    }
                } else if (conditionElement.val() != '0') {
                    url += '?condition=' + conditionElement.val()
                }
            }

            window.location = HELPERS.getLocalizedURL('/' + url);
        };

        var changeAction = function() {
            permutaElement.hide();
            ventaElement.hide();
            if (actionElement.val() == 'venta') {
                ventaElement.show();
            } else {
                permutaElement.show();
            }
        };



        var changeCondition = function() {
            if (conditionElement.val() == 'user') {
                specificDiv.show();
                conditionDiv.removeClass('small-12', 'small-4');
                conditionDiv.addClass('small-4')
            } else {
                specificDiv.hide();
                conditionDiv.removeClass('small-4', 'small-12');
                conditionDiv.addClass('small-12');
            }
        };
    }

})();
$(function() {
    var index = new INDEX();
    index.init();
});
