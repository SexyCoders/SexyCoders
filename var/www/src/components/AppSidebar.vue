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
      <CIcon
        custom-class-name="sidebar-brand-full"
        :icon="logoNegative"
        :height="35"
      />
      <CIcon
        custom-class-name="sidebar-brand-narrow"
        :icon="sygnet"
        :height="35"
      />
    </CSidebarBrand>
    <!--<AppSidebarNav />-->
    <CSidebarNav>
    <li class="nav-title">MANAGE</li>
    <CNavItem href="#" v-for="service in this.$store.etc.services" v-on:click.prevent="this.$router.push('/services/'+service.name);">
      {{service.name}}
    </CNavItem>
    <li class="nav-title">DATABASES</li>
    <CNavItem href="#" v-for="database in this.$store.etc.databases" v-on:click.prevent="this.$router.push('/databases/'+database.name);">
      {{database.name}}
    </CNavItem>
    <li class="nav-title">SPREADSHEETS</li>
    </CSidebarNav>
    <CSidebarToggler
      class="d-none d-lg-flex"
      @click="$store.commit('toggleUnfoldable')"
    />
  </CSidebar>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import { AppSidebarNav } from './AppSidebarNav'
import { logoNegative } from '@/assets/brand/logo-negative'
import { sygnet } from '@/assets/brand/sygnet'
export default {
  name: 'AppSidebar',
  components: {
    AppSidebarNav,
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
