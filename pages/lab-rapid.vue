<template>
  <v-row>
    <v-col cols="12">
      <v-card class="mx-auto">
        <v-toolbar color="#B980F0">
          <!-- <v-app-bar-nav-icon></v-app-bar-nav-icon> -->

          <h2>
            <v-icon size="30"> mdi-biohazard </v-icon>รายงานผล LAB ATK ({{
              showtitle
            }}
            จำนวน {{ showcountdata }} ราย)
          </h2>
          <v-spacer></v-spacer>
          <v-btn color="#51c4d3" dark x-large
            ><export-excel :data="rows">
              <v-icon size="30">mdi-file-excel </v-icon>
            </export-excel>
          </v-btn>
          <v-btn
            :loading="loading"
            x-large
            class="ma-1"
            color="#343A40"
            @click="refresh"
            align="end"
            dark
          >
            <v-icon medium>mdi-refresh </v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text
          ><div>
            <v-col cols="12">
              <v-radio-group v-model="showdata" row @change="changeshowdata">
                <v-radio value="day">
                  <template v-slot:label>
                    <div>
                      แสดงข้อมูลตาม
                      <strong :class="textcolorday">วันล่าสุด</strong>
                    </div>
                  </template></v-radio
                >
                <v-radio value="weeks">
                  <template v-slot:label>
                    <div>
                      แสดงข้อมูล
                      <strong :class="textcolorweeks">ย้อนหลัง 1 สปดาห์</strong>
                    </div>
                  </template></v-radio
                >
                <v-radio value="months">
                  <template v-slot:label>
                    <div>
                      แสดงข้อมูล
                      <strong :class="textcolormonths">ย้อนหลัง 1 เดือน</strong>
                    </div>
                  </template></v-radio
                >
                <v-radio value="all">
                  <template v-slot:label>
                    <div>
                      แสดงข้อมูล
                      <strong :class="textcolorall">ทั้งหมด</strong>
                    </div>
                  </template></v-radio
                >
              </v-radio-group>
            </v-col>
            <vue-good-table
              :line-numbers="true"
              :search-options="{ enabled: true, placeholder: 'ค้นหา' }"
              :columns="columns"
              :rows="rows"
              :pagination-options="{
                enabled: true,
                perPage: 10,

                nextLabel: 'ถัดไป',
                prevLabel: 'ก่อนหน้า',
                rowsPerPageLabel: 'แถวต่อหน้า',
                allLabel: 'ทั้งหมด',
              }"
            >
              <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field == 'result'">
                  <span
                    v-if="props.row.result == 'Negative'"
                    style="font-weight: bold; color: green"
                    >{{ props.row.result }}</span
                  >
                  <span v-else style="font-weight: bold; color: red">{{
                    props.row.result
                  }}</span>
                </span>

                <span v-else>
                  {{ props.formattedRow[props.column.field] }}
                </span>
              </template></vue-good-table
            >
          </div>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12"
      ><v-card>
        <v-toolbar color="#B980F0">
          <!-- <v-app-bar-nav-icon></v-app-bar-nav-icon> -->

          <h2>
            <v-icon size="30"> mdi-chart-bell-curve-cumulative </v-icon
            >กราฟเส้นแสดงจำนวนผู้ได้รับการตรวจ LAB ATK
            <u> ( {{ showcharttitle }} )</u>
          </h2>
          <v-spacer></v-spacer>
          <!-- <v-btn
            :loading="loading"
            x-large
            class="ma-1"
            color="#28527a"
            @click="refresh"
            align="end"
            dark
          >
            <v-icon medium>mdi-refresh </v-icon>
          </v-btn> -->
        </v-toolbar>
        <v-col cols="12">
          <v-btn
            class="ma-2"
            outlined
            color="indigo"
            @click="chartbtn_1_click"
            v-model="chartbtn"
          >
            แสดงรายวัน
          </v-btn>
          <v-btn
            class="ma-2"
            outlined
            color="indigo"
            @click="chartbtn_2_click"
            v-model="chartbtn"
          >
            แสดงรายสัปดาห์
          </v-btn>
        </v-col>
        <chart_line_rapid
          v-if="loadlineday"
          :lineday_datetime="lineday_datetime"
          :lineday_no_covid="lineday_no_covid"
          :lineday_yes_covid="lineday_yes_covid"
          :lineday_all_covid="lineday_all_covid"
        ></chart_line_rapid
      ></v-card>
    </v-col>
    <v-col cols="12"
      ><v-card>
        <v-toolbar color="#B980F0">
          <!-- <v-app-bar-nav-icon></v-app-bar-nav-icon> -->

          <h2>
            <v-icon size="30"> mdi-chart-box </v-icon
            >กราฟแท่งแสดงจำนวนผู้ได้รับการตรวจ LAB ATK
            <u> ( {{ showcharttitle }} )</u>
          </h2>
          <v-spacer></v-spacer>
          <!-- <v-btn
            :loading="loading"
            x-large
            class="ma-1"
            color="#28527a"
            @click="refresh"
            align="end"
            dark
          >
            <v-icon medium>mdi-refresh </v-icon>
          </v-btn> -->
        </v-toolbar>
        <v-col cols="12">
          <v-btn
            class="ma-2"
            outlined
            color="indigo"
            @click="chartbtn_1_click"
            v-model="chartbtn"
          >
            แสดงรายวัน
          </v-btn>
          <v-btn
            class="ma-2"
            outlined
            color="indigo"
            @click="chartbtn_2_click"
            v-model="chartbtn"
          >
            แสดงรายสัปดาห์
          </v-btn>
        </v-col>
        <chart_bar_rapid
          v-if="loadlineday"
          :lineday_datetime="lineday_datetime"
          :lineday_no_covid="lineday_no_covid"
          :lineday_yes_covid="lineday_yes_covid"
          :lineday_all_covid="lineday_all_covid"
        ></chart_bar_rapid
      ></v-card>
    </v-col>
    <v-dialog v-model="dialog" hide-overlay persistent width="300">
      <v-card color="#f25287" dark>
        <v-card-text>
          กำลังโหลดข้อมูล...
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import axios from 'axios'

import chart_line_rapid from '~/components/chart_line_rapid.vue'
import chart_bar_rapid from '~/components/chart_bar_rapid.vue'
export default {
  components: { chart_line_rapid, chart_bar_rapid },
  data() {
    return {
      dialog: false,
      columns: [
        {
          label: 'HN',
          field: 'HN',
          sortable: false,
        },
        {
          label: 'เลขบัตรประจำตัวประชาชน',
          field: 'ID_CARD',
          sortable: false,
        },
        {
          label: 'ชื่อสกุล',
          field: 'FULLNAME',
          sortable: false,
        },
        {
          label: 'Tel',
          field: 'TEL',
          sortable: false,
        },
        {
          label: 'Mobile',
          field: 'MOBILE',
          sortable: false,
        },
        {
          label: 'อายุ',
          field: 'AGE',
          sortable: false,
        },
        {
          label: 'วันที่ตรวจ',
          field: 'DATETIME',
          sortable: false,
        },
        {
          label: 'FINANCE_NO',
          field: 'OPD_FINANCE_NO',
          sortable: false,
          hidden: true,
        },
        {
          label: 'รหัส',
          field: 'LABCODE_DETAIL_CODE',
          sortable: false,
          hidden: true,
        },
        {
          label: 'LAB',
          field: 'NAME',
          sortable: false,
        },
        {
          label: 'ผล',
          field: 'result',
        },
        {
          label: 'ที่อยู่',
          field: 'HOME',
          sortable: false,
        },
        {
          label: 'ตำบล',
          field: 'TAMBON',
          sortable: false,
        },
        {
          label: 'อำเภอ',
          field: 'DISULT',
          sortable: false,
        },
        {
          label: 'จังหวัด',
          field: 'PROVINCE',
          sortable: false,
        },
      ],
      rows: [],
      lineday: '',
      lineday_datetime: '',
      lineday_no_covid: '',
      lineday_yes_covid: '',
      loadlineday: false,
      lineday_all_covid: '',
      showdata: 'day',
      textcolorday: 'primary--text',
      textcolorweeks: 'primary--text',
      textcolormonths: 'primary--text',
      textcolorall: 'primary--text',
      showtitle: '',
      showcountdata: '0',
      chartbtn: 'days',
      showcharttitle: 'รายวัน',
    }
  },
  mounted() {
    this.changeradiocolor()
    this.fetch_lab()
    this.chart_line()
  },
  methods: {
    //ตาราง เสียชีวิตราย ward

    async fetch_lab() {
      this.dialog = true
      await axios
        .get(`${this.$axios.defaults.baseURL}lab_rapid.php`, {
          params: {
            showdata: this.showdata,
          },
        })
        .then((response) => {
          this.rows = response.data
          this.dialog = false
          this.showcountdata = this.rows.length
        })
    },
    changeshowdata() {
      this.changeradiocolor()
      this.fetch_lab()
    },
    changeradiocolor() {
      this.showcountdata = ''
      if (this.showdata == 'day') {
        this.textcolorday = 'success--text'
        this.textcolorweeks = 'primary--text'
        this.textcolormonths = 'primary--text'
        this.textcolorall = 'primary--text'
        this.showtitle = 'รายวัน'
      } else if (this.showdata == 'weeks') {
        this.textcolorday = 'primary--text'
        this.textcolorweeks = 'success--text'
        this.textcolormonths = 'primary--text'
        this.textcolorall = 'primary--text'
        this.showtitle = 'รายสัปดาห์'
      } else if (this.showdata == 'months') {
        this.textcolorday = 'primary--text'
        this.textcolorweeks = 'primary--text'
        this.textcolormonths = 'success--text'
        this.textcolorall = 'primary--text'
        this.showtitle = 'รายเดือน'
      } else if (this.showdata == 'all') {
        this.textcolorday = 'primary--text'
        this.textcolorweeks = 'primary--text'
        this.textcolormonths = 'primary--text'
        this.textcolorall = 'success--text'
        this.showtitle = 'ทั้งหมด'
      }
    },
    refresh() {
      this.fetch_lab()
      this.chart_line()
      this.chart_risk()
    },

    //chart line + bar
    async chart_line() {
      this.dialog = true
      await axios
        .get(`${this.$axios.defaults.baseURL}chart_line_month_rapid.php`, {
          params: {
            chartbtn: this.chartbtn,
          },
        })
        .then((response) => {
          this.loadlineday = true
          this.lineday = response.data

          this.lineday_datetime = this.lineday.map((item) => item.datetime)
          this.lineday_no_covid = this.lineday.map((item) => item.no_covid)
          this.lineday_yes_covid = this.lineday.map((item) => item.yes_covid)
          this.lineday_all_covid = this.lineday.map((item) => item.all_covid)
          this.dialog = false
        })
    },
    chartbtn_1_click() {
      this.chartbtn = 'days'
      this.loadlineday = false
      this.showcharttitle = 'รายวัน'
      this.chart_line()
    },
    chartbtn_2_click() {
      this.chartbtn = 'weeks'
      this.loadlineday = false
      this.showcharttitle = 'รายสัปดาห์ (ปี-เดือน-สัปดาห์)'
      this.chart_line()
    },
  },
}
</script>
