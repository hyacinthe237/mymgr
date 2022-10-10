<template>
    <section>

        <div class="row">
            <div class="col-lg-4">
                <doughnut-chart :chart-data="datacollectionD" :options="pieOptions"></doughnut-chart>
            </div>
            <div class="col-lg-4">
                <bar-chart :chart-data="datacollectionB" :options="barOptions" ></bar-chart>
            </div>
        </div>
    </section>
</template>

<script>

import BarChart from '../../charts/bar-chart.vue'
import DoughnutChart from '../../charts/doughnut-chart.vue'

export default {
    props: ['stats'],

     components: { BarChart, DoughnutChart},

    data: () => ({
        users: [],
        chartDataB: [],
        chartDataD: [],
        datacollectionB: null,
        datacollectionD: null,
        pieOptions:null,
        barOptions: null
    }),

    mounted () {
        this.getUsers(),
        this.getChartData(),
        this.fillData(),
        this.setOptions()
    },

    methods: {

        getUsers () {
            this.users = this.stats.ticketsByUser.map(a => a.firstname);

        },

        getChartData () {
            this.chartDataB = this.stats.ticketsByUser.map(a => a.total);
            this.chartDataD = [this.stats.open, this.stats.close];
        },



        fillData () {

            this.datacollectionB = {
                  labels: this.users,
                  datasets: [
                    {
                      label: 'Tickets',
                      backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                      ],
                      data: this.chartDataB
                    }
                  ]
                }

            this.datacollectionD = {
                  labels: ['open', 'close'],
                  datasets: [
                    {
                      backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                      ],
                      data: this.chartDataD
                    }
                  ]
                }


        },


        setOptions () {

            this.barOptions = {
                scales: {
                    yAxes: [{
                        ticks: {
                            fixedStepSize: 1,
                            beginAtZero: true,
                            min: 0
                        }
                    }]
                }
            };
            this.pieOptions = {
              events: false,
              animation: {
                duration: 500,
                easing: "easeOutQuart",
                onComplete: function () {
                  var ctx = this.chart.ctx;
                  ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                  ctx.textAlign = 'center';
                  ctx.textBaseline = 'bottom';

                  this.data.datasets.forEach(function (dataset) {

                    for (var i = 0; i < dataset.data.length; i++) {
                      var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                          total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                          mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius)/2,
                          start_angle = model.startAngle,
                          end_angle = model.endAngle,
                          mid_angle = start_angle + (end_angle - start_angle)/2;

                      var x = mid_radius * Math.cos(mid_angle);
                      var y = mid_radius * Math.sin(mid_angle);

                      ctx.fillStyle = '#000';
                      if (i == 3){ // Darker text color for lighter background
                        ctx.fillStyle = '#444';
                      }
                      //var percent = String(Math.round(dataset.data[i]/total*100)) + "%";
                      ctx.fillText(dataset.data[i], model.x + x, model.y + y);
                      // Display percent in another line, line break doesn't work for fillText
                      //ctx.fillText(percent, model.x + x, model.y + y + 15);
                    }
                  });
                }
              }
            };

        },
    }
}
</script>
