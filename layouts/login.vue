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
      <span class="display-1"> ระบบตรวจสอบผล LAB และ ออกเลข SATCODE เพื่อ SWAB </span>
      <v-spacer></v-spacer>
        <h1> <v-icon size="30" >mdi-calendar-range </v-icon>{{ datenow }}</h1>
        <h1><v-icon size="30">mdi-clock-time-five-outline </v-icon>{{ timenow }}</h1>
    
    </v-system-bar>
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
              }
  },
    mounted() {this.pollData()}
}
</script>
<style  >


#app{
  font-family: 'Kanit', sans-serif;
  font-style: bold;
  font-weight: 40000;
}
</style>