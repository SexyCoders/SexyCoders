<template>
  <CHeader position="sticky" class="mb-4">
    <CContainer fluid>
      <CHeaderToggler class="ps-1" @click="$store.commit('toggleSidebar')">
        <CIcon icon="cil-menu" size="lg" />
      </CHeaderToggler>
      <CHeaderBrand class="mx-auto d-lg-none" to="/">
        <CIcon :icon="logo" height="48" alt="Logo" />
      </CHeaderBrand>
      <CHeaderNav class="d-none d-md-flex me-auto">
        <CNavItem>
          <CNavLink href="/dashboard"> Dashboard </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#">Users</CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#">Settings</CNavLink>
        </CNavItem>
      </CHeaderNav>
      <CHeaderNav>
      <CDropdown color="secondary" togglerText="Dropdown button">
        <CDropdownToggle component="a" color="success">Create</CDropdownToggle>
        <CDropdownMenu>
        <CNavItem href="#" v-for="action in this.$data.actions" v-on:click.prevent="this.$router.push('/create/'+action.name);" >
          <font-awesome-icon :icon="action.icon"/>
            {{action.name}}
          </CNavItem>
        </CDropdownMenu>
      </CDropdown>

        <CNavItem>
          <CNavLink href="#">
            <CIcon class="mx-2" icon="cil-bell" size="lg" />
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#">
            <CIcon class="mx-2" icon="cil-list" size="lg" />
          </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#">
            <CIcon class="mx-2" icon="cil-envelope-open" size="lg" />
          </CNavLink>
        </CNavItem>
        <AppHeaderDropdownAccnt />
      </CHeaderNav>
    </CContainer>
    <CHeaderDivider />
    <CContainer fluid>
      <AppBreadcrumb />
    </CContainer>
  </CHeader>
</template>

<script>
import AppBreadcrumb from './AppBreadcrumb'
import AppHeaderDropdownAccnt from './AppHeaderDropdownAccnt'
import { logo } from '@/assets/brand/logo'
export default {
  name: 'AppHeader',
  components: {
    AppBreadcrumb,
    AppHeaderDropdownAccnt,
  },
  data() {
  return{
    actions:[],
  }
  },
  mounted() {
   // this.createMenuObject();
    //window.menuObject=this.$data.menu;
  },
  beforeUnmount() {
  },
  beforeCreated()  {
  },
  created()  {
    this.createActions();
  },
  methods : {
    createActions(){
      this.$data.actions.push({name:'database',icon:'fa-solid fa-database'});
    },
  },
  setup() {
    return {
      logo,
    }
  },
}
</script>
