(function (window, $, rate_url) {
    /**
     * Currency exchange table.
     *
     * @constructor
     */
    function ExchangeTableView() {
    }

    /**
     * Update currency rate.
     *
     * @param rates {Object} {<currency_code>: <rubles>}
     */
    ExchangeTableView.prototype.update = function (rates) {
        if (typeof rates['EUR'] !== 'undefined' && rates['EUR']) {
            $('#rate__euro-rub').text(rates['EUR']);
            $('#rate__updated').text(new Date().toLocaleTimeString());
        }
    };

    /**
     * Exchange rate source.
     *
     * @param opts {Object}
     * @param opts.url {String} currency source url
     * @constructor
     */
    function ExchangeRateSource(opts) {
        this.url = opts.url;
    }

    /**
     * Load exchange rate.
     *
     * @returns {Promise.<Object>} {<currency_code>: <rubles>}
     */
    ExchangeRateSource.prototype.get = function () {
        var self = this;
        return $.ajax({
            url: self.url,
            method: 'GET',
            dataType: 'json'
        });
    };

    /**
     *
     * @param opts {Object}
     * @param opts.updateInterval {Number} milliseconds between updates
     * @param opts.table {Object} exchange table view
     * @param opts.source {Object} exchange rate source
     * @constructor
     */
    function ExchangeRateController (opts) {
        this.updateInterval = opts.updateInterval;
        this.table = opts.table;
        this.source = opts.source;
    }
    ExchangeRateController.prototype.run = function () {
        var self = this;
        var get_rate_loop = function () {
            self.source.get().then(function (rates) {
                self.table.update(rates);
            }).fail(function (jqXHR, textStatus, error) {
                console.log(textStatus + ":" + error);
            }).always(function () {
                setTimeout(get_rate_loop, 5 * 1000);
            });
        };
        get_rate_loop();
    };

    $(document).ready(function () {
        var rateTable = new ExchangeTableView();
        var rateSource = new ExchangeRateSource({url: rate_url});
        var rateController = new ExchangeRateController({
            updateInterval: 5 * 1000,
            table: rateTable,
            source: rateSource
        });
        rateController.run();
    });
})(window, $, rate_url);
