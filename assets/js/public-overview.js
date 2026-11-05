/*
 *Open Affiliates - Front-end Overview Data
 */
"use strict";
window.addEventListener( 'DOMContentLoaded', function(){
  var afDates = [];
  var afAmounts = [];
  var afLabels = [];
  var afAmountsBaseValues = [];
  jQuery( '.af-js-overview-stats-last-30' ).each(function( e, html ){
      afDates.push( jQuery(html).attr( 'data-date' ) );
      afAmounts.push( jQuery(html).attr( 'data-amount' ) );
      afLabels.push( jQuery(html).attr( 'data-label' ) );
      afAmountsBaseValues.push( jQuery(html).attr( 'data-base_amount' ) );
  });

var options = {
  maintainAspectRatio: false,
  spanGaps: false,
  elements: {
    line: {
      tension: 0.01
    }
  },
  plugins: {
    filler: {
      propagate: false
    }
  },
  scales: {
    x: {
      ticks: {
        autoSkip: false,
        maxRotation: 0,
      },
    },
    xAxes: [ { gridLines: { display: false } } ],
    yAxes: [{
           ticks: {
               beginAtZero: true,
               userCallback: function(label, index, labels) {
                   // when the floored value is the same as the value we have a whole number
                   if (Math.floor(label) === label) {
                       return label;
                   }

               },
           },
          scaleLabel: {
            display: true,
            labelString: jQuery( '.af-js-overview-earnings-received-label' ).attr('data-value')
          }
    }],
    scaleShowVerticalLines: false,
  },
  animation: {
        duration		: 2000,
        easing			: 'easeInQuad',
      },
}; // end of options

  var afChart = new Chart('chart-1', {
    type    : 'line',
    data    : {
      labels    : afLabels,
      datasets  : [{
          backgroundColor   : 'rgba(201,218,232,0.5)',
          borderColor       : '#c9dae8',
          data              : afAmountsBaseValues, //referrals counts
          label             : jQuery( '.af-js-overview-earnings-label').attr( 'data-value' ),
          pointRadius				: 3,
          fill							: 'start',
          borderWidth				: 2
      }]
    },
    options : Chart.helpers.merge(options, {
              legend: {
                    display: false
              },
              title: {
                text    : '',
                display : true
              },
              tooltips: {
                    intersect		: false,
                    position		: 'nearest',
                    callbacks: {
                      label: function(tooltipItem, data) {
                          var string = '';
                          afAmounts.forEach(function( val, i ){
                              if ( i == tooltipItem.index ){
                                string = val;
                              }
                          });
                          return string;
                      },
                      title: function(tooltipItem, data) {
                        var string = '';
                        afDates.forEach(function( val, i ){
                            if ( i == tooltipItem[0].index ){
                              string = val;
                            }
                        });
                        return string;
                      },
                    }
                }
    }),

  });

});
