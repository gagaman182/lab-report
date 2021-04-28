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
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="4"
              ><v-text-field
                label="ลำดับ"
                v-model="number_code"
                outlined
                x-large
                counter="4"
                class="display-1"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="6" align="center">
              <p class="headline text-decoration-underline">SAT CODE</p>
              <p class="display-2 red--text" v-if="show_status_ok">
                {{ satcode }}
              </p>
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
            {{ data_pmk }}
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
      tb_bg_color: '',
      dateadd: new Date().toISOString().substr(0, 10),
      data_pmk: [],
    }
  },
  mounted() {
    // this.hn_detail()
    this.day_code =
      new Date().toISOString().substr(8, 2) +
      new Date().toISOString().substr(5, 2) +
      new Date().toISOString().substr(2, 2)
  },
  methods: {
    // async fetch_hn() {
    //   await axios
    //     .get(`${this.$axios.defaults.baseURL}search_hn.php`)
    //     .then((response) => {
    //       this.hn_list = response.data
    //       this.hn_select = this.hn_list.map((item) => item.hn)
    //     })
    // },
    async hn_detail() {
      if (this.hn) {
        //check hn จากฐาน satcode
        await axios
          .post(`${this.$axios.defaults.baseURL}hn_detail.php`, {
            hn: this.hn,
          })
          .then((response) => {
            this.hn_check = response.data
            console.log(this.hn_check)
            if (
              typeof this.hn_check !== 'undefined' &&
              this.hn_check.length > 0
            ) {
              this.hn_status = 'ออกโค้ดแล้ว'
              this.tb_bg_color = '#00adb5'
              this.show_status_ok = true
              this.show_status_no = false

              this.prename = this.hn_check[0].prename
              this.fullname = this.hn_check[0].fullname
              this.tel = this.hn_check[0].tel
              this.risk = this.hn_check[0].risk
              this.type_code = this.hn_check[0].type_code
              this.day_code = this.hn_check[0].day_code
              this.name_code = this.hn_check[0].name_code
              this.number_code = this.hn_check[0].number_code
              this.dateadd = this.hn_check[0].dateadd
              this.satcode =
                '10682' +
                this.type_code +
                this.day_code +
                this.name_code +
                this.number_code
            } else {
              //check hn จากฐาน pmk เพื่อออก โค็ดใหม่
              this.hn_status = 'ยังไม่ได้ออกโค้ด'
              this.tb_bg_color = '#ff5e78'
              this.show_status_ok = false
              this.show_status_no = true

              axios
                .get(`${this.$axios.defaults.baseURL}search_hn.php`, {
                  params: {
                    hn: this.hn,
                  },
                })
                .then((response) => {
                  this.data_pmk = response.data
                  this.prename = this.data_pmk[0].prename
                  this.fullname = this.data_pmk[0].name
                })
            }
            // this.work_position = this.contact_detail.map(
            //   (item) => item.work_position
            // )
            // this.prename = this.contact_detail[0].prename
            // this.name = this.contact_detail[0].name
            // this.lastname = this.contact_detail[0].lastname
            // this.department = this.contact_detail[0].in_department
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
    },
    uppercase() {
      this.name_code = this.name_code.toUpperCase()
      this.type_code = this.type_code.toUpperCase()
    },
  },
}
</script>
<style scoped>
.code input {
  text-transform: uppercase;
}
</style>
