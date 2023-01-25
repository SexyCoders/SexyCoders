<template>
  <CSidebar
    position="fixed"
    :unfoldable="sidebarUnfoldable"
    :visible="sidebarVisible"
    @visible-change="
      (event) =>
        $store.commit({
          type: 'updateSidebarVisible',
          value: event,
        })
    "
  >
    <CSidebarBrand>
      <img
        :src='this.$data.logo'
        :height="50"
      />
      <CIcon
        custom-class-name="sidebar-brand-narrow"
        :icon="sygnet"
        :height="35"
      />
    </CSidebarBrand>
    <CSidebarNav>
    <li class="nav-title">
      <h5>MANAGE</h5>
      <CNavItem href="#" v-for="service in this.$store.etc.services" v-on:click.prevent="this.$store.tmp.selected_service=service;this.$router.push('/services/'+service.name);">
        {{service.name}}
      </CNavItem>
    </li>
    <!--<li class="nav-title">-->
      <!--<h5>DATABASES</h5>-->
      <!--<CNavItem href="#" v-for="database in this.$store.etc.databases" v-on:click.prevent="this.$store.tmp.selected_database=database;this.$router.push('/databases/'+database.database_id);">-->
        <!--{{database.database_name}}-->
      <!--</CNavItem>-->
    <!--</li>-->
    <!--<li class="nav-title">-->
      <!--<h5>SPREADSHEETS</h5>-->
    <!--</li>-->
      </CSidebarNav>
      <!--<CSidebarToggler-->
        <!--class="d-none d-lg-flex"-->
        <!--@click="$store.commit('toggleUnfoldable')"-->
      <!--/>-->
  </CSidebar>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import { logoNegative } from '@/assets/brand/logo-negative'
import { sygnet } from '@/assets/brand/sygnet'
export default {
  name: 'AppSidebar',
  data() {
  return{
    logo:'https://lib.sexycoders.org/share/logos/live/SexyCodersLogoText.png',
  }
  },
  components: {
  },
  setup() {
    const store = useStore()
    return {
      logoNegative,
      sygnet,
      sidebarUnfoldable: computed(() => store.state.sidebarUnfoldable),
      sidebarVisible: computed(() => store.state.sidebarVisible),
    }
  },
}
</script>
