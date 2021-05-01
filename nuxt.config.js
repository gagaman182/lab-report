import colors from 'vuetify/es5/util/colors'

export default {
    // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
    ssr: false,

    // Target: https://go.nuxtjs.dev/config-target
    target: 'static',

    // Global page headers: https://go.nuxtjs.dev/config-head
    head: {
        titleTemplate: '%s - lab',
        title: 'lab',
        htmlAttrs: {
            lang: 'en',
        },
        meta: [
            { charset: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1' },
            { hid: 'description', name: 'description', content: '' },
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
            {
                rel: 'stylesheet',
                href: 'https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap',
            },
        ],
    },

    // Global CSS: https://go.nuxtjs.dev/config-css
    css: [],

    // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
    plugins: [
        { src: '~/plugins/vue-good-table', ssr: false },
        '@/plugins/apexcharts.js',
        '@/plugins/vueexcel',
    ],

    // Auto import components: https://go.nuxtjs.dev/config-components
    components: true,

    // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
    buildModules: [
        // https://go.nuxtjs.dev/vuetify
        '@nuxtjs/vuetify',
    ],

    // Modules: https://go.nuxtjs.dev/config-modules
    modules: [
        // https://go.nuxtjs.dev/axios
        '@nuxtjs/axios',
        'vue-sweetalert2/nuxt',
        // 'nuxt-basic-auth-module',
    ],
    // basic auth
    // basic: {
    //     name: 'srrt10682',
    //     pass: 'srrt1925',
    //     // enabled: process.env.BASIC_ENABLED === 'true',
    //     // require boolean value(nullable)
    // },

    // Axios module configuration: https://go.nuxtjs.dev/config-axios
    axios: {
        //home
        //baseURL: 'http://localhost/labreport/backend/',
        // 4.3
        baseURL: 'http://192.168.4.3/webapp/lab-report/backend/',
        //server 5.1
        // baseURL: 'http://192.168.4.3/webapp/dashboardgoals/backend/',
        //takis
        // baseURL: 'http://61.19.25.207/dsonline/backend/',
    },

    // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
    vuetify: {
        customVariables: ['~/assets/variables.scss'],
        theme: {
            dark: false,
            themes: {
                dark: {
                    primary: colors.blue.darken2,
                    accent: colors.grey.darken3,
                    secondary: colors.amber.darken3,
                    info: colors.teal.lighten1,
                    warning: colors.amber.base,
                    error: colors.deepOrange.accent4,
                    success: colors.green.accent3,
                },
            },
        },
    },

    // Build Configuration: https://go.nuxtjs.dev/config-build
    build: {},
    // setให้สามารถ run คำสั่ง npm run generate แล้วได้ ไฟล์ dist เอาข้างในไป ใส่ใน path ที่เราต้องการ
    router: {
        base: '/webapp/lab-report',
    },
}