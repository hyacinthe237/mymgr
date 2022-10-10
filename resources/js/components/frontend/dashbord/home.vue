<template>
    <section class="content-body">
        <div class="blocks-team-items mt-20">
            <div class="row">
                <div class="col-lg-4">
                         <div class="form-group">
                                <label>Project</label>
                                <select class="form-control input-lg"
                                    name="project"
                                    @change="changeProjectChart" >
                                    <option v-for="item in projects" :value="item.id">{{ item.title }}</option>
                                </select>
                            </div>
                        <line-chart :chart-data="datacollection"></line-chart>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import LineChart from '../charts/line-chart.vue'

export default {
    name: 'dashbord',

    components: { LineChart },

    props: ['statistics'],

    data: () => ({
        chartData: [],
        projects: [],
        datacollection: null
    }),

    mounted () {
        this.getProjects(),
        this.getChartData(),
        this.fillData()
    },

    methods: {

        getProjects () {
            this.projects = this.statistics.project.project_rates.map(function(item) { var obj = {}; obj.id =item.id; obj.title =item.title; return obj; });
        },

        changeProjectChart (e) {
            this.getChartData(e.target.value);
            this.fillData();
        },

        getChartData (project_id=null) {
            var project = this.statistics.project.project_rates.find(function(item) {
                return item.id >=  project_id;
            });

            if (project) {
                var ticketRates=project.ticketRates;
                ticketRates = Object.keys(ticketRates).map(function(k) { return ticketRates[k] });
                this.chartData = ticketRates.map(a => a.rate);
                this.chartData = this.chartData.reduce((a, x, i) => [...a, x + (a[i-1] || 0)], []);
            }
        },

        fillData () {
        this.datacollection = {
          labels: ['Week1', 'Week2', 'Week3', 'Week4', 'Week5'],
          datasets: [
            {
              label: 'Tickets',
              //backgroundColor: '#f87979',
              data: this.chartData
            }
          ]
        }
      }


    }
}
</script>
