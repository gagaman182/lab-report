<template>
  <v-card class="mx-auto">
    <v-toolbar color="#845ec2" dark>
      <h2>
        <v-icon size="30"> mdi-card-account-details-outline </v-icon>
        ข้อมูลการเพิ่ม SAT CODE ประจำวันที่ {{ datenow }}
      </h2>
      <v-spacer></v-spacer>
    </v-toolbar>

    <v-card-text>
      <v-col cols="12">
        <v-btn
          color="#29bb89"
          x-large
          dark
          class="display-1 mx-2"
          @click="call_parent"
        >
          <v-icon size="40"> mdi-account-plus-outline </v-icon>
          &nbsp; </v-btn
        ><v-btn
          mx-4
          color="#ffdf6b"
          x-large
          dark
          class="display-1"
          @click="mark_y"
        >
          <v-icon size="40"> mdi-file-upload-outline </v-icon>
          &nbsp;
        </v-btn></v-col
      >

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
    </v-card-text>
  </v-card>
</template>
<script>
import axios from 'axios'
export default {
  components: {},

  props: ['move_up_add', 'reset_child_all'],

  data: () => ({
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
      },
      {
        label: 'ช่วงเวลา',
        field: 'other',
        sortable: false,
      },
    ],
    idemit: '',
    message: '',
  }),
  mounted() {
    this.fetch_satcode()
  },
  methods: {
    async fetch_satcode() {
      await axios
        .get(`${this.$axios.defaults.baseURL}satcode_day.php`)
        .then((response) => {
          this.satcode_day = response.data
        })
    },
    //click row send id to parent
    onRowClick(params) {
      this.idemit = params.row.id
      this.$emit('getid', this.idemit)
      window.scrollTo({
        top: 100,
        left: 100,
        behavior: 'smooth',
      })
    },
    //call parent  method
    call_parent() {
      this.move_up_add()
    },
    // mark y
    async mark_y() {
      await axios
        .put(`${this.$axios.defaults.baseURL}update_satcode_y.php`)
        .then((response) => {
          this.message = response.data
          if (this.message[0].message === 'อัพโหลดข้อมูลสำเร็จ') {
            this.$swal({
              title: 'สถานะการอัพโหลด',
              text: this.message[0].message,
              icon: 'success',
              confirmButtonText: 'ตกลง',
            })

            this.fetch_satcode()
            this.reset_child_all()
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
