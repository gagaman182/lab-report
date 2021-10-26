<template>
  <div class="app">
    <apexchart
      type="line"
      height="500"
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
        name: 'High - 2013',
        data: [28, 29, 33, 36, 32, 32, 33],
      },
      {
        name: 'High - 2013',
        data: [28, 29, 33, 36, 32, 32, 33],
      },
    ],
    chartOptions: {
      chart: {
        height: 350,
        type: 'line',
        dropShadow: {
          enabled: true,
          color: '#000',
          top: 18,
          left: 7,
          blur: 10,
          opacity: 0.2,
        },
        toolbar: {
          show: false,
        },
      },
      colors: ['#77B6EA', '#545454'],
      dataLabels: {
        enabled: true,
      },
      stroke: {
        curve: 'smooth',
      },
      title: {
        text: 'จำนวน/วัน ',
        align: 'left',
        style: {
          fontSize: '18px',
          fontFamily: 'Kanit, sans-serif',
        },
      },
      grid: {
        borderColor: '#e7e7e7',
        row: {
          colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
          opacity: 0.5,
        },
      },
      markers: {
        size: 1,
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],

        title: {
          text: 'วันที่ตรวจ',
          style: {
            fontSize: '18px',
            fontFamily: 'Kanit, sans-serif',
          },
        },
        labels: {
          rotate: -45,
          style: {
            fontSize: '18px',
            fontFamily: 'Kanit, sans-serif',
          },
        },
      },
      yaxis: {
        title: {
          text: 'จำนวน',
          style: {
            fontSize: '18px',
            fontFamily: 'Kanit, sans-serif',
          },
        },
        labels: {
          style: {
            fontSize: '16px',
            fontFamily: 'Kanit, sans-serif',
          },
        },

        // min: 5,
        // max: 40,
      },

      colors: ['#F5E79D', '#FE9898'],
      legend: {
        position: 'top',
        horizontalAlign: 'right',
        floating: true,
        offsetY: -25,
        offsetX: -5,
      },
      tooltip: {
        style: {
          fontSize: '18px',
          fontFamily: 'Kanit, sans-serif',
        },
      },
      dataLabels: {
        enabled: true,

        style: {
          fontSize: '18px',
          fontFamily: 'Kanit, sans-serif',
          fontWeight: 'bold',
        },
      },
    },
  }),
  beforeMount() {
    this.series[0].name = 'Negative'
    this.series[0].data = this.lineday_all_covid
    this.series[1].name = 'Positive'
    this.series[1].data = this.lineday_yes_covid

    this.chartOptions.xaxis.categories = this.lineday_datetime

    // //เอา array แรกเลยใช้ [0]
    // this.chartOptions.title.text = `ปีงบ ${this.linemonth_years[0]}`
  },
}
</script>
