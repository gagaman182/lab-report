<template>
  <div class="app">
    <apexchart
      type="bar"
      width="98%"
      :options="chartOptions"
      :series="series"
    ></apexchart>
  </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts'
import axios from 'axios'
export default {
  components: {
    apexchart: VueApexCharts,
  },

  props: {
    lineday_datetime: null,
    lineday_no_covid: null,
    lineday_yes_covid: null,
    lineday_all_covid: null,
  },

  data: () => ({
    series: [
      {
        data: [44, 55, 41, 64, 22, 43, 21],
      },
      {
        data: [53, 32, 33, 52, 13, 44, 32],
      },
      // {
      //   data: [53, 32, 33, 52, 13, 44, 32],
      // },
    ],
    chartOptions: {
      chart: {
        type: 'bar',
        height: 430,
      },
      plotOptions: {
        bar: {
          horizontal: false,
          dataLabels: {
            position: 'top',
          },
        },
      },
      dataLabels: {
        enabled: true,
        offsetX: -6,
        style: {
          fontSize: '12px',
          colors: ['#fff'],
        },
      },
      stroke: {
        show: true,
        width: 1,
        colors: ['#fff'],
      },
      tooltip: {
        shared: true,
        intersect: false,
        style: {
          fontSize: '18px',
          fontFamily: 'Kanit, sans-serif',
        },
      },
      xaxis: {
        categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
        labels: {
          style: {
            fontSize: '16px',
            fontFamily: 'Kanit, sans-serif',
          },
        },
        title: {
          text: 'จำนวน',
          style: {
            fontSize: '18px',
            fontFamily: 'Kanit, sans-serif',
          },
        },
      },
      yaxis: {
        labels: {
          style: {
            fontSize: '18px',
            fontFamily: 'Kanit, sans-serif',
          },
        },
      },
      legend: {
        position: 'bottom',
        fontSize: '18px',
        fontFamily: 'Kanit, sans-serif',
      },
      colors: ['#f56a79', '#01c5c4'],
      tooltip: {
        style: {
          fontSize: '18px',
          fontFamily: 'Kanit, sans-serif',
        },
      },
      dataLabels: {
        enabled: true,

        style: {
          fontSize: '16px',
          fontFamily: 'Kanit, sans-serif',
          fontWeight: 'bold',
        },
      },
    },
  }),
  beforeMount() {
    this.series[0].name = 'Negative'
    this.series[0].data = this.lineday_yes_covid
    this.series[1].name = 'Positive'
    this.series[1].data = this.lineday_no_covid
    // this.series[2].data = this.lineday_all_covid
    this.chartOptions.xaxis.categories = this.lineday_datetime

    // //เอา array แรกเลยใช้ [0]
    // this.chartOptions.title.text = `ปีงบ ${this.linemonth_years[0]}`
  },
}
</script>
