<template>
  <v-card>
    <v-card-text>
      <v-row>
        <v-col cols="12" class="mx-auto">
          <v-toolbar color="#de8971" dark>
            <h2>
              <v-icon size="30"> mdi-card-account-details-outline </v-icon>
              ข้อมูลการออก SAT CODE ทั้งหมด
            </h2>
            <v-spacer></v-spacer>
            <h2>
              <v-icon size="30">mdi-calendar-range </v-icon> &nbsp;{{ datenow }}
            </h2>
            <v-btn color="#7b6079" dark x-large class="mx-4" @click="refresh">
              <v-icon size="30">mdi-refresh-circle </v-icon>
            </v-btn>
            <v-btn color="#51c4d3" dark x-large
              ><export-excel :data="excel_thai">
                <v-icon size="30">mdi-file-excel </v-icon>
              </export-excel>
            </v-btn>
          </v-toolbar>
        </v-col>
        <v-col cols="12"
          ><v-alert color="#2A3B4D" dark icon="mdi-alarm " dense>
            ระบบจำประมวลผลข้อมูลทุก 15 วินาที
          </v-alert></v-col
        >
        <v-col>
          <vue-good-table
            :line-numbers="true"
            :search-options="{ enabled: true, placeholder: 'ค้นหา' }"
            :columns="columns"
            :rows="satcode_day"
            @on-row-click="onRowClick"
            :pagination-options="{
              enabled: true,
              perPage: 10,

              nextLabel: 'ถัดไป',
              prevLabel: 'ก่อนหน้า',
              rowsPerPageLabel: 'แถวต่อหน้า',
              allLabel: 'ทั้งหมด',
            }"
          >
          </vue-good-table>
        </v-col>
        <v-dialog v-model="dialog" hide-overlay persistent width="300">
          <v-card color="#de8971" dark>
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
    </v-card-text>
  </v-card>
</template>
<script>
import axios from 'axios'
export default {
  components: {},
  layout: 'ic',
  data: () => ({
    dialog: false,
    datenow: new Date().toLocaleString().substr(0, 8),
    satcode_day: [],
    columns: [
      {
        label: 'id',
        field: 'id',
        hidden: true,
      },
      {
        label: 'HN',
        field: 'hn',
        sortable: false,
      },
      {
        label: 'คำนำหน้าชื่อ',
        field: 'prename',
        sortable: false,
      },
      {
        label: 'ชื่อ-สกุล',
        field: 'fullname',
        sortable: false,
      },
      {
        label: 'เบอร์โทร',
        field: 'tel',
        sortable: false,
      },
      {
        label: 'ความเสี่ยง',
        field: 'risk',
        sortable: false,
      },
      {
        label: 'SAT CODE',
        field: 'satcode',
        sortable: false,
      },
      {
        label: 'วันที่ตรวจ',
        field: 'dateadd',
        sortable: false,
        // dateInputFormat: 'yyyy-MM-dd',
        // dateOutputFormat: 'dd-MM-yyyy',
      },
      {
        label: 'ช่วงเวลา',
        field: 'other',
        sortable: false,
      },
    ],
    idemit: '',
    btndown: false,

    hn: '',
    prename: '',
    fullname: '',
    message: '',
    excel_thai: '',
    timer: '',
  }),
  mounted() {
    this.fetch_satcode()

    this.fecth_satcode_excel()
  },
  // refresh ทุก 5วิ ไปเรียก refresh_settimeout สั่ง refresh 2 ชั้น
  created() {
    this.refresh_settimeout()
    this.timer = setInterval(this.refresh_settimeout, 15000)
  },

  methods: {
    async fetch_satcode() {
      this.dialog = true
      await axios
        .get(`${this.$axios.defaults.baseURL}satcode_all_ic.php`)
        .then((response) => {
          this.satcode_day = response.data
          this.dialog = false
        })
    },
    //click row send id to parent
    onRowClick(params) {
      this.btndown = true
      this.idemit = params.row.id
    },
    async fecth_satcode_excel() {
      await axios
        .get(`${this.$axios.defaults.baseURL}satcode_excel.php`)
        .then((response) => {
          this.excel_thai = response.data
        })
    },
    refresh() {
      this.fetch_satcode()
    },
    // refresh tabl ทุก 5 วิ
    refresh_settimeout() {
      setInterval(this.fetch_satcode(), 15000)
    },
  },
}
</script>
<style></style>
