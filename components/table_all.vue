<template>
  <v-card>
    <v-card-text>
      <v-row>
        <v-col cols="12" class="mx-auto">
          <v-toolbar color="#ea97ad" dark>
            <h2>
              <v-icon size="30"> mdi-card-account-details-outline </v-icon>
              ข้อมูลการออก SAT CODE ทั้งหมด
            </h2>
            <v-spacer></v-spacer>
          </v-toolbar>
        </v-col>
        <v-col>
          <v-col v-if="btndown" class="display-1">
            <v-btn
              v-if="btndown"
              color="#ffdf6b"
              x-large
              dark
              class="display-1 mx-6"
              @click="restore_upload"
            >
              <v-icon size="40"> mdi-file-download-outline </v-icon>
              &nbsp; </v-btn
            >HN&nbsp;{{ hn }} &nbsp;{{ prename }} &nbsp;ชื่อ&nbsp;{{ fullname }}
          </v-col>

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
    </v-card-text>
  </v-card>
</template>
<script>
import axios from 'axios'
export default {
  components: {},

  props: ['reset_child'],

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
        type: 'date',
        dateInputFormat: 'yyyy-MM-dd', // expects 2018-03-16
        dateOutputFormat: 'dd-MM-yyyy', // outputs Mar 16th 2018
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
  }),
  mounted() {
    this.fetch_satcode()
  },
  methods: {
    async fetch_satcode() {
      this.dialog = true
      await axios
        .get(`${this.$axios.defaults.baseURL}satcode_all.php`)
        .then((response) => {
          this.satcode_day = response.data
          this.dialog = false
        })
    },
    //click row send id to parent
    onRowClick(params) {
      this.btndown = true
      this.idemit = params.row.id
      this.hn = params.row.hn
      this.prename = params.row.prename
      this.fullname = params.row.fullname

      // this.$emit('getid', this.idemit)
      // window.scrollTo({
      //   top: 100,
      //   left: 100,
      //   behavior: 'smooth',
      // })
    },
    clear() {
      this.idemit = ''
      this.hn = ''
      this.prename = ''
      this.fullname = ''
      this.btndown = false
      //reset table หน้าออกโค้ด
      this.move_up_add()
    },
    restore_upload() {
      axios
        .put(`${this.$axios.defaults.baseURL}update_satcode_no_y.php`, {
          id: this.idemit,
        })
        .then((response) => {
          this.message = response.data
          if (this.message[0].message === 'ยกเลิกอัพโหลดข้อมูลสำเร็จ') {
            this.$swal({
              title: 'สถานะการอัพโหลด',
              text: this.message[0].message,
              icon: 'success',
              confirmButtonText: 'ตกลง',
            })
            this.fetch_satcode()
            this.reset_child()
            this.clear()
          } else {
            this.$swal({
              title: 'สถานะการอัพโหลด',
              text: this.message[0].message,
              icon: 'error',
              confirmButtonText: 'ตกลง',
            })
          }
        })
    },
  },
}
</script>
<style></style>
