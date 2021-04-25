<template>
  <v-row>
    <v-col cols="12">
      <v-card class="mx-auto">
        <v-toolbar color="#a2d0c1">
          <!-- <v-app-bar-nav-icon></v-app-bar-nav-icon> -->

          <h2>
            <v-icon size="30"> mdi-database-clock </v-icon>รายงานผล LAB COVID-19
            จาก PMK
          </h2>
          <v-spacer></v-spacer>
          <v-btn
            :loading="loading"
            x-large
            class="ma-1"
            color="#28527a"
            @click="refresh"
            align="end"
            dark
          >
            <v-icon medium>mdi-refresh </v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text
          ><div>
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
                    v-if="props.row.result == 'Not Detected'"
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
export default {
  components: {},
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
      ],
      rows: [],
    }
  },
  mounted() {
    this.fetch_lab()
  },
  methods: {
    //ตาราง เสียชีวิตราย ward

    async fetch_lab() {
      this.dialog = true
      await axios
        .get(`${this.$axios.defaults.baseURL}lab_pui.php`)
        .then((response) => {
          this.rows = response.data
          this.dialog = false
        })
    },
    refresh() {
      this.fetch_lab()
    },
  },
}
</script>
