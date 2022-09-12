<template>
  <router-view />
</template>

<script>
export default {
  name: 'App',
  components: {
  },
  data() {
  return{
  }
  },
  mounted() {
    this.createMenuObject();
    //window.menuObject=this.$data.menu;
  },
  beforeUnmount() {
  },
  beforeCreated()  {
  },
  created()  {
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
    createMenuObject()
      {
        var t=[
          {
            component: 'CNavItem',
            name: 'Dashboard',
            to: '/dashboard',
            icon: 'cil-speedometer',
            badge: {
              color: 'primary',
              text: 'NEW',
            },
          },
        ];

        ///////////////////////////////////////
        //MANAGE
        ///////////////////////////////////////
        t.push(
          {
            component: 'CNavTitle',
            name: 'MANAGE',
          },
        );

        ///////////////////////////////////////
        //DATABASES
        ///////////////////////////////////////
        t.push(
          {
            component: 'CNavTitle',
            name: 'DATABASES',
          },
        );
        console.log(this.$store.etc.databases);
          this.$store.etc.databases.forEach((database) => {
                t.push(
                  {
                    component: 'CNavItem',
                    name: 'Colors',
                    to: '/theme/colors',
                    //icon: 'cil-drop',
                  },
                );
              });
        t.push(
          {
            component: 'CNavTitle',
            name: 'SPREADSHEETS',
          },
        );
      this.$data.menu=t;
        window.menuObject=t;
      },

}
}
</script>

<style lang="scss">
// Import Main styles for this application
@import 'styles/style';
</style>
