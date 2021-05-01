<template>
  <v-card>
    <v-tabs v-model="tab" background-color="#9fb8ad">
      <v-tab v-for="item in item_tab" :key="item.tab">
        <v-icon size="30">{{ item.icon }}</v-icon
        >&nbsp;
        <h2>{{ item.tab }}</h2>
      </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <v-col cols="12">
              <v-card class="mx-auto">
                <v-toolbar color="#845ec2" dark>
                  <h2>
                    <v-icon size="30"> mdi-barcode-scan </v-icon> ออกผล SAT CODE
                  </h2>
                  <v-spacer></v-spacer>
                  <v-btn
                    v-if="show_status_edit"
                    @click="add_edit_clear"
                    depressed
                    color="#007580"
                  >
                    ยกเลิก
                  </v-btn>
                  <v-chip
                    v-if="show_status_ok"
                    class="ma-2 h2"
                    color="#00adb5"
                    >{{ hn_status }}</v-chip
                  >
                  <v-chip
                    v-if="show_status_no"
                    class="ma-2 h2"
                    color="#e84545"
                    >{{ hn_status }}</v-chip
                  >
                  <v-chip
                    v-if="show_status_edit"
                    class="ma-2 h2"
                    color="#e48900"
                    >{{ hn_status }}</v-chip
                  >
                </v-toolbar>
                <v-card-text>
                  <v-row>
                    <v-col cols="12" md="4"
                      ><v-text-field
                        ref="hn"
                        :background-color="tb_bg_color"
                        label="HN"
                        v-model="hn"
                        outlined
                        x-large
                        @keyup.enter="hn_detail()"
                        class="headline"
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4"
                      ><v-text-field
                        label="คำนำหน้าชื่อ"
                        v-model="prename"
                        outlined
                        x-large
                        class="headline"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4"
                      ><v-text-field
                        label="ชื่อ-นามสกุล"
                        v-model="fullname"
                        outlined
                        x-large
                        class="headline"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col cols="12" md="4"
                      ><v-text-field
                        label="เบอร์โทรศัพท์"
                        v-model="tel"
                        outlined
                        x-large
                        class="headline"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="8"
                      ><v-text-field
                        label="ประวัติความเสี่ยง"
                        v-model="risk"
                        outlined
                        x-large
                        class="headline"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col cols="12" md="2"
                      ><v-text-field
                        label="โรงพยาบาล"
                        v-model="hoscode"
                        outlined
                        x-large
                        counter="5"
                        class="headline"
                        @keyup.enter="change_code"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2"
                      ><v-text-field
                        label="ประเภท"
                        v-model="type_code"
                        outlined
                        x-large
                        counter="1"
                        @keyup="uppercase"
                        @keyup.enter="change_code"
                        class="headline"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2"
                      ><v-text-field
                        label="วันที่"
                        v-model="day_code"
                        outlined
                        x-large
                        counter="6"
                        class="headline"
                        @keyup.enter="change_code"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2"
                      ><v-text-field
                        label="อักษรตัวแรก"
                        v-model="name_code"
                        outlined
                        x-large
                        class="code headline"
                        counter="2"
                        @keyup="uppercase"
                        @keyup.enter="change_code"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2"
                      ><v-text-field
                        label="ลำดับ"
                        v-model="number_code"
                        outlined
                        x-large
                        counter="4"
                        class="headline"
                        @keyup.enter="change_code"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                      <!-- <v-text-field
                label="อื่นๆ"
                v-model="other"
                outlined
                x-large
                class="display-1"
              ></v-text-field> -->
                      <v-select
                        :items="items"
                        v-model="other"
                        :menu-props="{ top: true, offsetY: true }"
                        label="ช่วงเวลา"
                        outlined
                        x-large
                        class="headline"
                      ></v-select>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col cols="12" md="6" align="center">
                      <p class="headline text-decoration-underline">SAT CODE</p>
                      <p class="display-2 blue--text">
                        {{ satcode }}
                      </p>

                      <v-btn
                        v-if="btnshow"
                        color="#29bb89"
                        x-large
                        dark
                        class="display-1"
                        @click="add_satcode"
                      >
                        <v-icon size="40"> mdi-account-plus-outline </v-icon>
                        &nbsp;เพิ่มข้อมูล
                      </v-btn>
                      <v-btn
                        v-if="show_status_edit"
                        color="#e48900"
                        x-large
                        dark
                        class="display-1"
                        @click="update_satcode"
                      >
                        <v-icon size="40"> mdi-account-edit-outline </v-icon>
                        &nbsp;แก้ไขข้อมูล
                      </v-btn>
                      <v-btn
                        v-if="show_status_edit"
                        color="#e84545"
                        x-large
                        dark
                        class="display-1"
                        @click="delete_satcode"
                      >
                        <v-icon size="40"> mdi-account-remove-outline </v-icon>
                        &nbsp;ลบข้อมูล
                      </v-btn>
                    </v-col>
                    <v-col cols="12" md="6" align="center">
                      <p class="headline text-decoration-underline">
                        วันที่ส่งตรวจ
                      </p>
                      <v-date-picker
                        v-model="dateadd"
                        readonly
                        locale="th-TH"
                        color="#ea97ad"
                      ></v-date-picker>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-col>
            <!-- prop function คือ จาก แม่ไปลูก
            จากลูกไปแม่ใช่ส่ง ref -->
            <v-col cols="12"
              ><table_satcode
                ref="resatcode"
                :move_up_add="move_up_add"
                :reset_child_all="reset_child_all"
                @getid="fecth_edit"
              ></table_satcode>
            </v-col>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <!-- prop function คือ จาก แม่ไปลูก
            จากลูกไปแม่ใช่ส่ง ref -->
            <table_all
              ref="resatcodeall"
              :reset_child="reset_child"
              @getid="fecth_edit"
            ></table_all>
          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
import axios from 'axios'

import table_satcode from '~/components/table_satcode.vue'
import table_all from '~/components/table_all.vue'
export default {
  components: {
    table_satcode,
    table_all,
  },
  data() {
    return {
      hn: '',
      hn_check: '',
      hn_status: '',
      show_status_ok: false,
      show_status_no: false,
      show_status_edit: false,
      show_satcode: false,
      prename: '',
      fullname: '',
      tel: '',
      risk: '',
      hoscode: '10682',
      type_code: 'A',
      day_code: '',
      name_code: '',
      number_code: '',
      satcode: '',
      other: '',
      tb_bg_color: '',
      dateadd: new Date().toISOString().substr(0, 10),
      data_pmk: [],
      run_numbers: '',
      numbers_count: '',
      nameinitail: '',
      namefinal: '',
      btnshow: false,
      message: '',
      items: ['เช้า', 'บ่าย'],
      edit_satcode: '',
      id_edit: '',
      tab: '',
      item_tab: [
        { tab: 'เพิ่มSATCODE', icon: 'mdi-barcode-scan' },
        { tab: 'SATCODEทั้งหมด', icon: 'mdi-card-account-details-outline' },
      ],
    }
  },
  mounted() {
    this.day_code =
      new Date().toISOString().substr(8, 2) +
      new Date().toISOString().substr(5, 2) +
      new Date().toISOString().substr(2, 2)
  },
  methods: {
    //หาจำนวนผู้ป่วยว่ามีกี่คนแล้ว
    fecth_run_number() {
      axios
        .get(`${this.$axios.defaults.baseURL}run_number.php`)
        .then((response) => {
          let numbers = response.data

          if (parseInt(numbers[0].maxnumber) < '10') {
            this.run_numbers = '000' + (parseInt(numbers[0].maxnumber) + 1)
          } else if (
            parseInt(numbers[0].maxnumber) > '10' &&
            parseInt(numbers[0].maxnumber) < '100'
          ) {
            this.run_numbers = '00' + (parseInt(numbers[0].maxnumber) + 1)
          } else if (
            parseInt(numbers[0].maxnumber) > '100' &&
            parseInt(numbers[0].maxnumber) < '1000'
          ) {
            this.run_numbers = '0' + (parseInt(numbers[0].maxnumber) + 1)
          } else if (parseInt(numbers[0].maxnumber) > '1000') {
            this.run_numbers = parseInt(numbers[0].maxnumber) + 1
          }
        })
    },

    async hn_detail() {
      //เรียกดูผู้ป่วยวันนี้ก่อน
      this.fecth_run_number()
      if (this.hn) {
        //clear hn ก่อน search
        this.beforsearch()
        //check hn จากฐาน satcode
        await axios
          .post(`${this.$axios.defaults.baseURL}hn_detail.php`, {
            hn: this.hn,
          })
          .then((response) => {
            this.hn_check = response.data

            if (
              typeof this.hn_check !== 'undefined' &&
              this.hn_check.length > 0
            ) {
              this.hn_status = 'ออกโค้ดแล้ว'
              this.tb_bg_color = '#00adb5'
              this.show_status_ok = true
              this.show_status_no = false
              this.show_status_edit = false
              this.show_satcode = true

              this.prename = this.hn_check[0].prename
              this.fullname = this.hn_check[0].fullname
              this.tel = this.hn_check[0].tel
              this.risk = this.hn_check[0].risk
              this.type_code = this.hn_check[0].type_code
              this.day_code = this.hn_check[0].day_code
              this.name_code = this.hn_check[0].name_code
              this.number_code = this.hn_check[0].number_code
              // this.dateadd = this.hn_check[0].dateadd
              this.satcode =
                this.hoscode +
                this.type_code +
                this.day_code +
                this.name_code +
                this.number_code
              this.other = this.hn_check[0].other
              this.btnshow = true
            } else {
              //check hn จากฐาน pmk เพื่อออก โค็ดใหม่
              this.hn_status = 'ยังไม่ได้ออกโค้ด'
              this.tb_bg_color = '#ff5e78'
              this.show_status_ok = false
              this.show_status_no = true
              this.show_status_edit = false
              this.show_satcode = true
              axios
                .get(`${this.$axios.defaults.baseURL}search_hn.php`, {
                  params: {
                    hn: this.hn,
                  },
                })
                .then((response) => {
                  this.data_pmk = response.data
                  if (this.data_pmk.length == 0) {
                    this.$swal({
                      title: 'ไม่สามารถดึงข้อมูลมาได้',
                      text: 'ไม่มี HN' + this.hn + 'อยู่ในระบบ',
                      icon: 'error',
                      confirmButtonText: 'ตกลง',
                    })
                  } else {
                    this.btnshow = true
                    this.prename = this.data_pmk[0].prename
                    this.fullname = this.data_pmk[0].fullname
                    this.tel = this.data_pmk[0].tel
                    this.number_code = this.run_numbers

                    let nameinitail = this.data_pmk[0].name.substring(0, 1)
                    let namefinal = this.data_pmk[0].surname.substring(0, 1)
                    //ชื่อ
                    if (
                      nameinitail == 'ก' ||
                      nameinitail == 'ข' ||
                      nameinitail == 'ค' ||
                      nameinitail == 'ฆ'
                    ) {
                      nameinitail = 'K'
                      this.nameinitail = nameinitail
                    } else if (
                      nameinitail == 'ง' ||
                      nameinitail == 'น' ||
                      nameinitail == 'ณ'
                    ) {
                      nameinitail = 'N'
                      this.nameinitail = nameinitail
                    } else if (
                      nameinitail == 'จ' ||
                      nameinitail == 'ฉ' ||
                      nameinitail == 'ช' ||
                      nameinitail == 'ฌ'
                    ) {
                      nameinitail = 'C'
                      this.nameinitail = nameinitail
                    } else if (nameinitail == 'ญ' || nameinitail == 'ย') {
                      nameinitail = 'Y'
                      this.nameinitail = nameinitail
                    } else if (
                      nameinitail == 'ด' ||
                      nameinitail == 'ฎ' ||
                      nameinitail == 'ฑ'
                    ) {
                      nameinitail = 'D'
                      this.nameinitail = nameinitail
                    } else if (
                      nameinitail == 'ต' ||
                      nameinitail == 'ฏ' ||
                      nameinitail == 'ถ' ||
                      nameinitail == 'ฐ' ||
                      nameinitail == 'ท' ||
                      nameinitail == 'ฑ' ||
                      nameinitail == 'ธ' ||
                      nameinitail == 'ฒ'
                    ) {
                      nameinitail = 'T'
                      this.nameinitail = nameinitail
                    } else if (nameinitail == 'บ') {
                      nameinitail = 'B'
                      this.nameinitail = nameinitail
                    } else if (
                      nameinitail == 'ผ' ||
                      nameinitail == 'พ' ||
                      nameinitail == 'ภ' ||
                      nameinitail == 'ป'
                    ) {
                      nameinitail = 'P'
                      this.nameinitail = nameinitail
                    } else if (nameinitail == 'ฝ' || nameinitail == 'ฟ') {
                      nameinitail = 'F'
                      this.nameinitail = nameinitail
                    } else if (nameinitail == 'ม') {
                      nameinitail = 'M'
                      this.nameinitail = nameinitail
                    } else if (nameinitail == 'ร') {
                      nameinitail = 'R'
                      this.nameinitail = nameinitail
                    } else if (nameinitail == 'ล' || nameinitail == 'ฬ') {
                      nameinitail = 'L'
                      this.nameinitail = nameinitail
                    } else if (nameinitail == 'ว') {
                      nameinitail = 'W'
                      this.nameinitail = nameinitail
                    } else if (
                      nameinitail == 'ช' ||
                      nameinitail == 'ศ' ||
                      nameinitail == 'ษ' ||
                      nameinitail == 'ส'
                    ) {
                      nameinitail = 'S'
                      this.nameinitail = nameinitail
                    } else if (nameinitail == 'ห' || nameinitail == 'ฮ') {
                      nameinitail = 'H'
                      this.nameinitail = nameinitail
                    }
                    //สกุล
                    if (
                      namefinal == 'ก' ||
                      namefinal == 'ข' ||
                      namefinal == 'ค' ||
                      namefinal == 'ฆ'
                    ) {
                      namefinal = 'K'
                      this.namefinal = namefinal
                    } else if (
                      namefinal == 'ง' ||
                      namefinal == 'น' ||
                      namefinal == 'ณ'
                    ) {
                      namefinal = 'N'
                      this.namefinal = namefinal
                    } else if (
                      namefinal == 'จ' ||
                      namefinal == 'ฉ' ||
                      namefinal == 'ช' ||
                      namefinal == 'ฌ'
                    ) {
                      namefinal = 'C'
                      this.namefinal = namefinal
                    } else if (namefinal == 'ญ' || namefinal == 'ย') {
                      namefinal = 'Y'
                      this.namefinal = namefinal
                    } else if (
                      namefinal == 'ด' ||
                      namefinal == 'ฎ' ||
                      namefinal == 'ฑ'
                    ) {
                      namefinal = 'D'
                      this.namefinal = namefinal
                    } else if (
                      namefinal == 'ต' ||
                      namefinal == 'ฏ' ||
                      namefinal == 'ถ' ||
                      namefinal == 'ฐ' ||
                      namefinal == 'ท' ||
                      namefinal == 'ฑ' ||
                      namefinal == 'ธ' ||
                      namefinal == 'ฒ'
                    ) {
                      namefinal = 'T'
                      this.namefinal = namefinal
                    } else if (nameinitail == 'บ') {
                      namefinal = 'B'
                      this.namefinal = namefinal
                    } else if (
                      namefinal == 'ผ' ||
                      namefinal == 'พ' ||
                      namefinal == 'ภ' ||
                      namefinal == 'ป'
                    ) {
                      namefinal = 'P'
                      this.namefinal = namefinal
                    } else if (namefinal == 'ฝ' || namefinal == 'ฟ') {
                      namefinal = 'F'
                      this.namefinal = namefinal
                    } else if (namefinal == 'ม') {
                      namefinal = 'M'
                      this.namefinal = namefinal
                    } else if (namefinal == 'ร') {
                      namefinal = 'R'
                      this.namefinal = namefinal
                    } else if (namefinal == 'ล' || namefinal == 'ฬ') {
                      namefinal = 'L'
                      this.namefinal = namefinal
                    } else if (namefinal == 'ว') {
                      nameinitail = 'W'
                      this.namefinal = namefinal
                    } else if (
                      namefinal == 'ช' ||
                      namefinal == 'ศ' ||
                      namefinal == 'ษ' ||
                      namefinal == 'ส'
                    ) {
                      namefinal = 'S'
                      this.namefinal = namefinal
                    } else if (namefinal == 'ห' || namefinal == 'ฮ') {
                      namefinal = 'H'
                      this.namefinal = namefinal
                    }

                    this.name_code = this.nameinitail + this.namefinal
                    this.satcode =
                      this.hoscode +
                      this.type_code +
                      this.day_code +
                      this.name_code +
                      this.number_code
                  }
                })
            }
          })
      } else {
        this.clear()
      }
    },
    clear() {
      this.hn = ''
      this.prename = ''
      this.fullname = ''
      this.tel = ''
      this.risk = ''
      this.satcode = ''
      this.hoscode = '10682'
      this.type_code = 'A'
      this.day_code = ''
      this.name_code = ''
      this.number_code = ''
      this.hn_status = ''
      this.dateadd = new Date().toISOString().substr(0, 10)
      this.show_status_ok = false
      this.show_status_no = false
      this.show_status_edit = false
      this.tb_bg_color = ''
      this.day_code =
        new Date().toISOString().substr(8, 2) +
        new Date().toISOString().substr(5, 2) +
        new Date().toISOString().substr(2, 2)
      this.other = ''
      this.btnshow = false
    },
    beforsearch() {
      this.prename = ''
      this.fullname = ''
      this.tel = ''
      this.risk = ''
      this.satcode = ''
      this.hoscode = '10682'
      this.type_code = 'A'
      this.day_code = ''
      this.name_code = ''
      this.number_code = ''
      this.hn_status = ''
      this.dateadd = new Date().toISOString().substr(0, 10)
      this.show_status_ok = false
      this.show_status_no = false
      this.show_status_edit = false
      this.tb_bg_color = ''
      this.day_code =
        new Date().toISOString().substr(8, 2) +
        new Date().toISOString().substr(5, 2) +
        new Date().toISOString().substr(2, 2)
      this.other = ''
      this.satcode = ''
      this.btnshow = false
      //เลื่อนลง
    },
    add_edit_clear() {
      this.hn = ''
      this.prename = ''
      this.fullname = ''
      this.tel = ''
      this.risk = ''
      this.satcode = ''
      this.hoscode = '10682'
      this.type_code = 'A'
      this.day_code = ''
      this.name_code = ''
      this.number_code = ''
      this.hn_status = ''
      this.dateadd = new Date().toISOString().substr(0, 10)
      this.show_status_ok = false
      this.show_status_no = false
      this.show_status_edit = false
      this.tb_bg_color = ''
      this.day_code =
        new Date().toISOString().substr(8, 2) +
        new Date().toISOString().substr(5, 2) +
        new Date().toISOString().substr(2, 2)
      this.other = ''
      this.btnshow = false
      //เลื่อนลง
      window.scrollTo({
        top: 1200,
        left: 50,
        behavior: 'smooth',
      })
    },
    uppercase() {
      this.name_code = this.name_code.toUpperCase()
      this.type_code = this.type_code.toUpperCase()
    },
    //กรณีเปลี่ยน ข้อความ code กลางคัน
    change_code() {
      this.satcode =
        this.hoscode +
        this.type_code +
        this.day_code +
        this.name_code +
        this.number_code
    },
    //เพิ่มข้อมูล
    async add_satcode() {
      await axios
        .post(`${this.$axios.defaults.baseURL}add_satcode.php`, {
          hn: this.hn,
          prename: this.prename,
          fullname: this.fullname,
          tel: this.tel,
          risk: this.risk,
          satcode: this.satcode,
          type_code: this.type_code,
          day_code: this.day_code,
          name_code: this.name_code,
          number_code: this.number_code,
          other: this.other,
          dateadd: this.dateadd,
        })
        .then((response) => {
          this.message = response.data
          if (this.message[0].message == 'เพิ่มข้อมูลสำเร็จ') {
            this.$swal({
              title: 'การเพิ่มข้อมูล',
              text: this.message[0].message,
              icon: 'success',
              confirmButtonText: 'ตกลง',
            })
            this.$refs.resatcode.fetch_satcode()
            this.add_edit_clear()
          } else {
            this.$swal({
              title: 'การเพิ่มข้อมูล',
              text: this.message[0].message,
              icon: 'error',
              confirmButtonText: 'ตกลง',
            })
          }
        })
    },
    //แก้ไข satcode รับค่ามาจาก component ลูก
    async fecth_edit(value) {
      this.id_edit = value
      this.hn_status = 'แก้ไขโค้ด'
      this.tb_bg_color = '#e48900'
      this.show_status_ok = false
      this.show_status_no = false
      this.show_status_edit = true
      await axios
        .post(`${this.$axios.defaults.baseURL}edit_satcode.php`, {
          id: this.id_edit,
        })
        .then((response) => {
          this.edit_satcode = response.data
          this.hn = this.edit_satcode[0].hn
          this.prename = this.edit_satcode[0].prename
          this.fullname = this.edit_satcode[0].fullname
          this.tel = this.edit_satcode[0].tel
          this.risk = this.edit_satcode[0].risk
          this.satcode = this.edit_satcode[0].satcode
          this.type_code = this.edit_satcode[0].type_code
          this.day_code = this.edit_satcode[0].day_code
          this.name_code = this.edit_satcode[0].name_code
          this.number_code = this.edit_satcode[0].number_code
          this.other = this.edit_satcode[0].other
          this.dateadd = this.edit_satcode[0].dateadd
        })
    },
    //แก้ไข satcode

    async update_satcode() {
      await axios
        .put(`${this.$axios.defaults.baseURL}update_satcode.php`, {
          id: this.id_edit,
          hn: this.hn,
          prename: this.prename,
          fullname: this.fullname,
          tel: this.tel,
          risk: this.risk,
          satcode: this.satcode,
          type_code: this.type_code,
          day_code: this.day_code,
          name_code: this.name_code,
          number_code: this.number_code,
          other: this.other,
          dateadd: this.dateadd,
        })
        .then((response) => {
          this.message = response.data
          if (this.message[0].message === 'แก้ไขข้อมูลสำเร็จ') {
            this.$swal({
              title: 'สถานะการแก้ไข',
              text: this.message[0].message,
              icon: 'success',
              confirmButtonText: 'ตกลง',
            })
            this.add_edit_clear()
            this.$refs.resatcode.fetch_satcode()
            this.$refs.resatcodeall.fetch_satcode()
          } else {
            this.$swal({
              title: 'สถานะการแก้ไข',
              text: this.message[0].message,
              icon: 'error',
              confirmButtonText: 'ตกลง',
            })
          }
        })
    },
    //ลบ satcode
    delete_satcode() {
      if (!this.id_edit) {
        this.$swal({
          title: 'แจ้งเตือน',
          text: 'ไม่พบข้อมูล',
          icon: 'error',
          confirmButtonText: 'ตกลง',
        })
      } else {
        this.$swal({
          title: 'คุณแน่ใจว่าต้องการลบข้อมูลนี้?',
          text: 'hn: ' + this.hn + ' ' + 'ชื่อ:' + this.fullname,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#51adcf',
          cancelButtonColor: '#686d76',
          confirmButtonText: 'ลบ',
          cancelButtonText: 'ยกเลิก',
        }).then((result) => {
          if (result.isConfirmed) {
            axios
              .put(`${this.$axios.defaults.baseURL}delete_satcode.php`, {
                id: this.id_edit,
              })
              .then((response) => {
                this.message = response.data

                if (this.message[0].message === 'ลบข้อมูลสำเร็จ') {
                  this.$swal({
                    title: 'สถานะการลบ',
                    text: this.message[0].message,
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                  })
                  this.add_edit_clear()
                  this.$refs.resatcode.fetch_satcode()
                  this.move_up_add()
                } else {
                  this.$swal({
                    title: 'สถานะการลบ',
                    text: this.message[0].message,
                    icon: 'error',
                    confirmButtonText: 'ตกลง',
                  })
                }
              })
          }
        })
      }
    },
    move_up_add() {
      //reset ก่อน
      this.add_edit_clear()
      //ให้ mouse focus ไปที่ช่อง textfield hn บรรทัดที่ 30
      this.$refs.hn.focus()
      //เลื่อนขึ้น
      window.scrollTo({
        top: 100,
        left: 100,
        behavior: 'smooth',
      })
    },
    //สั่ง methed จาก child to parent แล้วจาก parent to childต่อ
    reset_child() {
      this.$refs.resatcode.fetch_satcode()
    },
    reset_child_all() {
      this.$refs.resatcodeall.fetch_satcode()
    },
  },
}
</script>
<style scoped>
.v-text-field .v-input__control .v-input__slot {
  min-height: auto !important;
  display: flex !important;
  align-items: center !important;
}
</style>
