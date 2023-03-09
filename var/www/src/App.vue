<template>
  <div>
    <AppSidebar v-if="this.$store.proc.layout.sidebar"/>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
      <AppHeader v-if="this.$store.proc.layout.header"/>
      <div class="body flex-grow-1 px-3">
        <CContainer lg>
          <router-view />
        </CContainer>
      </div>
      <AppFooter v-if="this.$store.proc.layout.footer"/>
    </div>
  </div>
</template>

<script>
import AppFooter from '@/components/AppFooter.vue'
import AppHeader from '@/components/AppHeader.vue'
import AppSidebar from '@/components/AppSidebar.vue'
import { CContainer } from '@coreui/vue'

export default {
  name: 'MainApp',
  components: {
    AppFooter,
    AppHeader,
    AppSidebar,
    CContainer,
  },
  data() {
  return{
  }
  },
  created() {
  },
  mounted() {
    //this.createMenuObject();
    //window.menuObject=this.$data.menu;
  },
  metaInfo() {
    return {
            title: 'Home',
            titleTemplate: '%s | My Awesome Webapp',
            meta: [
              { name: "robots", content: "index,follow" },
            ],
        }
  },
  beforeUnmount() {
  },
  beforeCreated()  {
  },
  created()  {
    console.log(this.$store.proc.layout);
    console.log('I AM RUNNING');
  },
  computed() {
  },
  methods : {
    auth(){
      var time = this;
      setInterval(function () {
       time.localTime = new Date().toLocaleTimeString();
      }, 5000);
    },
    //createMenuObject()
      //{
       // var t=[
       //   {
       //     component: 'CNavItem',
       //     name: 'Dashboard',
       //     to: '/dashboard',
       //     icon: 'cil-speedometer',
       //     badge: {
       //       color: 'primary',
       //       text: 'NEW',
       //     },
       //   },
       // ];

       // ///////////////////////////////////////
       // //MANAGE
       // ///////////////////////////////////////
       // t.push(
       //   {
       //     component: 'CNavTitle',
       //     name: 'MANAGE',
       //   },
       // );

       // ///////////////////////////////////////
       // //DATABASES
       // ///////////////////////////////////////
       // t.push(
       //   {
       //     component: 'CNavTitle',
       //     name: 'DATABASES',
       //   },
       // );
    //    console.log(this.$store.etc.databases);
       //   this.$store.etc.databases.forEach((database) => {
       //         t.push(
       //           {
       //             component: 'CNavItem',
       //             name: 'Colors',
       //             to: '/theme/colors',
       //             //icon: 'cil-drop',
       //           },
       //         );
       //       });
       //         t.push(
       //           {
       //             component: 'CNavItem',
       //             name: 'Colors',
       //             to: '/theme/colors',
       //             //icon: 'cil-drop',
       //           },
       //         );
       // t.push(
       //   {
       //     component: 'CNavTitle',
       //     name: 'SPREADSHEETS',
       //   },
       // );
     // this.$data.menu=t;
     //   window.menuObject=t;
     //},

}
}
</script>

<style lang="scss">
// Import Main styles for this application
@import 'styles/style';
</style>
