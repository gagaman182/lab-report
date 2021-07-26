<template>
  <v-card class="mx-auto">
    <v-toolbar color="#ca8a8b" dark>
      <h2>
        <v-icon size="30"> mdi-chart-bar-stacked</v-icon>
        รายงานผลการเก็บตัวอย่างในกลุ่มผู้เข้าเกณท์สอบส่วนโรคส่งตรวจหาเชื้อโควิท19
        โรงพยาบาลหาดใหญ่
      </h2>
      <v-spacer></v-spacer>
    </v-toolbar>

    <v-card-text>
      <div id="chart">
        <apexchart
          type="bar"
          :options="chartOptions"
          :series="series"
        ></apexchart>
      </div>
    </v-card-text>
  </v-card>
</template>
<script>
import VueApexCharts from 'vue-apexcharts'
import axios from 'axios'
export default {
  components: {
    apexchart: VueApexCharts,
  },

  props: {
    columnday_day: null,
    columnday_risk1: null,
    columnday_risk2: null,
    columnday_risk3: null,
    columnday_risk4: null,
    columnday_risk5: null,
  },

  data: () => ({
    series: [
      {
        name: 'risk1',
        data: [44, 55, 41, 67, 22, 43],
      },
      {
        name: 'risk2',
        data: [13, 23, 20, 8, 13, 27],
      },
      {
        name: 'risk3',
        data: [11, 17, 15, 15, 21, 14],
      },
      {
        name: 'risk4',
        data: [21, 7, 25, 13, 22, 8],
      },
      {
        name: 'risk5',
        data: [21, 7, 25, 13, 22, 8],
      },
    ],
    chartOptions: {
      chart: {
        type: 'bar',
        height: 350,
        stacked: true,
        toolbar: {
          show: true,
        },
        zoom: {
          enabled: true,
        },
      },
      responsive: [
        {
          breakpoint: 480,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0,
            },
          },
        },
      ],
      plotOptions: {
        bar: {
          borderRadius: 8,
          horizontal: false,
        },
      },
      xaxis: {
        // type: 'datetime',
        categories: ['1', '2'],
        labels: {
          style: {
            fontSize: '16px',
            fontFamily: 'Kanit, sans-serif',
          },
        },
      },
      yaxis: {
        labels: {
          style: {
            fontSize: '16px',
            fontFamily: 'Kanit, sans-serif',
          },
        },
      },

      legend: {
        position: 'right',
        offsetY: 40,
        fontSize: '18px',
        fontFamily: 'Kanit, sans-serif',
      },
      // title: {
      //   text:
      //     'รายงานผลการเก็บตัวอย่างในกลุ่มผู้เข้าเกณท์สอบส่วนโรคส่งตรวจหาเชื้อโควิท19 โรงพยาบาลหาดใหญ่ ',
      //   align: 'left',
      //   style: {
      //     fontSize: '25px',
      //     fontFamily: 'Kanit, sans-serif',
      //   },
      // },
      fill: {
        opacity: 1,
      },
      colors: ['#ef476f', '#ffd166', '#06d6a0', '#118ab2', '#073b4c'],
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
    this.series[0].name = 'PUI Case'
    this.series[0].data = this.columnday_risk1
    this.series[1].name = 'Pneumonia'
    this.series[1].data = this.columnday_risk2
    this.series[2].name = 'PRE-OP'
    this.series[2].data = this.columnday_risk3
    this.series[3].name = 'บุคลากรทางการแพทย์'
    this.series[3].data = this.columnday_risk4
    this.series[4].name = 'High Risk ตรวจซ้ำครั้งที่ 2'
    this.series[4].data = this.columnday_risk5
    this.chartOptions.xaxis.categories = this.columnday_day
  },
}
</script>
