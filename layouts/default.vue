<template>
  <v-app dark>
    <v-navigation-drawer
      v-model="drawer"
      :mini-variant="miniVariant"
      :clipped="clipped"
      fixed
      app
    >
      <v-list>
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          :to="item.to"
          router
          exact
        >
          <v-list-item-action>
            <v-icon >{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
        <v-system-bar
        color="#f8dc81"
        height="150pm"
      window
   
    >
      <v-icon size="100">mdi-chemical-weapon  </v-icon>
      <span class="display-3"> LAB COVID-19</span>
      <v-spacer></v-spacer>
     
    
        <h1> <v-icon size="30" >mdi-calendar-range </v-icon>{{ datenow }}</h1>
        <h1><v-icon size="30">mdi-clock-time-five-outline </v-icon>{{ timenow }}</h1>
    
    </v-system-bar>
   
   

     
        <v-col col="12" md="12">
           <v-btn text>
       <NuxtLink to="/">LAB</NuxtLink>
    </v-btn>
    <v-btn
      text
      color="primary"
    >
     <NuxtLink to="/add-code">CODE</NuxtLink>
    </v-btn>
     </v-col>
    <v-row
      >
         
        <v-col col="12" md="6">
          <div>
            <v-card-title color="orange lighten-2">
                          ผู้ใช้งานระบบ : <v-chip
                  class="ma-2"
                  color="primary"
                  outlined
                  pill
                >
                  {{ user }} 
                  <v-icon right>
                    mdi-account-outline
                  </v-icon>
                </v-chip>
            </v-card-title>
          </div>
        </v-col>
        <v-col col="12" md="6">
          <div align="end">
            <!-- <v-btn class="ma-1" color="error" plain x-large @click="logout()">
              ออกจากระบบ
            </v-btn> -->
                <v-btn
                    class="mx-5"
                    fab
                    dark
                
                    color="#fa1e0e"
                    @click="logout()"
                  >
                    <v-icon dark>
                    mdi-logout-variant 
                    </v-icon>
              </v-btn>
          </div>
        </v-col>
      </v-row>
    <!-- <v-app-bar :clipped-left="clipped" fixed app> -->
      <!-- <v-app-bar-nav-icon @click.stop="drawer = !drawer" /> -->
      <!-- <v-btn icon @click.stop="miniVariant = !miniVariant">
        <v-icon>mdi-{{ `chevron-${miniVariant ? 'right' : 'left'}` }}</v-icon>
      </v-btn> -->
      <!-- <v-btn icon @click.stop="clipped = !clipped">
        <v-icon>mdi-application</v-icon>
      </v-btn> -->
      <!-- <v-btn icon @click.stop="fixed = !fixed">
        <v-icon>mdi-minus</v-icon>
      </v-btn> -->
      <!-- <v-toolbar-title v-text="title" /> -->
      <!-- <v-spacer /> -->
      <!-- <v-btn icon @click.stop="rightDrawer = !rightDrawer">
        <v-icon>mdi-menu</v-icon>
      </v-btn> -->
    </v-app-bar>
    <v-main>
      <v-container>
        <nuxt />
      </v-container>
    </v-main>
    <v-navigation-drawer v-model="rightDrawer" :right="right" temporary fixed>
      <v-list>
        <v-list-item @click.native="right = !right">
          <v-list-item-action>
            <v-icon light> mdi-repeat </v-icon>
          </v-list-item-action>
          <v-list-item-title>Switch drawer (click me)</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-footer :absolute="!fixed" app>
      <span>&copy; {{ new Date().getFullYear() }} งานป้องกันควบคุมโรคและระบาดวิทยา</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
       datenow: new Date().toLocaleString().substr(0, 10),
      timenow:'',
      timerun:'',
      clipped: true,
      drawer: false,
      fixed: true,
      items: [
        {
          icon: 'mdi-chemical-weapon',
          title: 'lab',
          to: '/',
        },
        
      ],
      miniVariant: true,
      right: true,
      rightDrawer: false,
      title: 'LAB',
    }
  },
  methods: {
                pollData () {
                          this.timerun = setInterval(() => {
                          this.timenow = new Date().toString().substr(16, 8)
                          }, 1000)
                        },
                         login() {
                    //check login
                    this.session = JSON.parse(localStorage.getItem('token'))
                    //ถ้าไม่มี session จาก ฐานข้อมูลคือไม่ได้ login ให้กลับไปหน้า /login
                    if (!this.session) {
                      this.$router.push('/login')
                    } else {
                      this.user = this.session[0].fullname
                      this.token = this.session[0].token

                      if (this.token.length <= 0) {
                        this.$router.push('/login')
                      } else {
                        // login 2 ชม ถ้าเกินให้ออก แล้ว clear localstorage
                        this.hours = 2
                        this.saved = localStorage.getItem('saved')
                        if (
                          this.saved &&
                          new Date().getTime() - this.saved > this.hours * 60 * 60 * 1000
                        ) {
                          localStorage.clear()
                          this.$router.push('/login')
                        }
                      }
                    }
                  },
                logout() {
                  localStorage.removeItem('token')
                  localStorage.clear()
                  this.$router.push('/login')
                },
                        
            },
  mounted() {
              this.pollData()
                this.login()
            }
}
</script>
<style  >


#app{
  font-family: 'Kanit', sans-serif;
  font-style: bold;
  font-weight: 40000;
}
</style>