module.exports = {
    load: 'highcharts',
    setup: function (Highcharts) {
        Highcharts.setOptions({
            lang: {
                decimalPoint: '.',
                thousandsSep: ',',
            },
        });
    },
};