<template>
  <v-row>
    <v-col cols="12">
      <v-card class="mx-auto">
        <v-toolbar color="#845ec2" dark>
          <h2><v-icon size="30"> mdi-barcode-scan </v-icon> ออกผล SAT CODE</h2>
          <v-spacer></v-spacer>

          <v-chip v-if="show_status_ok" class="ma-2 h2" color="#00adb5">{{
            hn_status
          }}</v-chip>
          <v-chip v-if="show_status_no" class="ma-2 h2" color="#e84545">{{
            hn_status
          }}</v-chip>
        </v-toolbar>
        <v-card-text>
          <v-row>
            <v-col cols="12" md="4"
              ><v-text-field
                :background-color="tb_bg_color"
                label="HN"
                v-model="hn"
                outlined
                x-large
                @change="hn_detail()"
                class="display-1"
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="4"
              ><v-text-field
                label="คำนำหน้าชื่อ"
                v-model="prename"
                outlined
                x-large
                class="display-1"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="4"
              ><v-text-field
                label="ชื่อ-นามสกุล"
                v-model="fullname"
                outlined
                x-large
                class="display-1"
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
                class="display-1"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="8"
              ><v-text-field
                label="ประวัติความเสี่ยง"
                v-model="risk"
                outlined
                x-large
                class="display-1"
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
                class="display-1"
                @change="change_code"
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
                @change="change_code"
                class="display-1"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="2"
              ><v-text-field
                label="วันที่"
                v-model="day_code"
                outlined
                x-large
                counter="6"
                class="display-1"
                @change="change_code"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="2"
              ><v-text-field
                label="อักษรตัวแรก"
                v-model="name_code"
                outlined
                x-large
                class="code display-1"
                counter="2"
                @keyup="uppercase"
                @change="change_code"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="2"
              ><v-text-field
                label="ลำดับ"
                v-model="number_code"
                outlined
                x-large
                counter="4"
                class="display-1"
                @change="change_code"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="2"
              ><v-text-field
                label="อื่นๆ"
                v-model="other"
                outlined
                x-large
                class="display-1"
              ></v-text-field>
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
            </v-col>
            <v-col cols="12" md="6" align="center">
              <p class="headline text-decoration-underline">วันที่ส่งตรวจ</p>
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
  </v-row>
</template>

<script>
import axios from 'axios'

// import chart_line from '~/components/chart_line.vue'
// import chart_bar from '~/components/chart_bar.vue'
export default {
  components: {},
  data() {
    return {
      hn: '',
      hn_check: '',
      hn_status: '',
      show_status_ok: false,
      show_status_no: false,
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
      this.hoscode = '10682'
      this.type_code = 'A'
      this.day_code = ''
      this.name_code = ''
      this.number_code = ''
      this.hn_status = ''
      this.dateadd = new Date().toISOString().substr(0, 10)
      this.show_status_ok = false
      this.show_status_no = false
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
      this.hoscode = '10682'
      this.type_code = 'A'
      this.day_code = ''
      this.name_code = ''
      this.number_code = ''
      this.hn_status = ''
      this.dateadd = new Date().toISOString().substr(0, 10)
      this.show_status_ok = false
      this.show_status_no = false
      this.tb_bg_color = ''
      this.day_code =
        new Date().toISOString().substr(8, 2) +
        new Date().toISOString().substr(5, 2) +
        new Date().toISOString().substr(2, 2)
      this.other = ''
      this.satcode = ''
      this.btnshow = false
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
            this.clear()
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
