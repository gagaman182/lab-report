<template>
  <v-card class="mx-auto">
    <v-toolbar color="#5089C6" dark>
      <h2>
        <v-icon size="30"> mdi-calendar</v-icon>
        ปฏิทินแสดงผลการรายกงานผลรายวัน
      </h2>
      <v-spacer></v-spacer>
    </v-toolbar>

    <v-card-text>
  
    
      <FullCalendar :options="calendarOptions" />
       <v-row>
    <v-col>
        <v-dialog v-model="dialog" hide-overlay persistent width="300">
          <v-card color="#5089C6" dark>
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
          </v-col>
      </v-row>
    </v-card-text>
  </v-card>
    
</template>
<script>
import '@fullcalendar/core/vdom' 
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
 import axios from 'axios'
   //แก้ไทย
 import allLocales from '@fullcalendar/core/locales-all';
export default {
  components: {
  FullCalendar 
  },

 

  data: () => ({
     calendarOptions: {
        plugins: [ dayGridPlugin, interactionPlugin ],
        initialView: 'dayGridMonth',
        // dateClick: this.handleDateClick,
        eventColor: '#810000',
      //แก้ไทย
            locales: allLocales,
            locale: 'th' ,
        events: [
          //  {   
       
          //    title: 'Event1',
          //    date: '2021-07-25',
          // },
          //  { 
          //      title: 'Event2',
          //    date: '2021-07-25',
          // },
          // { 
          //      title: 'Event3',
          //    date: '2021-07-28',
          // },
        ],
       
      },
      dialog: true,
  }),
   mounted() {
    this.fetch_lab_all_calender()
   

  },

    methods: {
      async fetch_lab_all_calender() {
      this.dialog = true
      await axios
        .get(`${this.$axios.defaults.baseURL}laball_calendar.php`)
        .then((response) => {
          this.calendarOptions.events = response.data
        
             this.dialog = false

           

        })
        
  
     }
     
  },
 
}
</script>
