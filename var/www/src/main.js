import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import CoreuiVue from '@coreui/vue'
import CIcon from '@coreui/icons-vue'
import { iconsSet as icons } from '@/assets/icons'
import DocsCallout from '@/components/DocsCallout'
import DocsExample from '@/components/DocsExample'

import Keycloak, { KeycloakConfig, KeycloakInstance } from 'keycloak-js';

//KEYCLOAK
//
const initOptions = {
  url: process.env.VUE_APP_KEYCLOAK_OPTIONS_URL,
  realm: process.env.VUE_APP_KEYCLOAK_OPTIONS_REALM,
  clientId: process.env.VUE_APP_KEYCLOAK_OPTIONS_CLIENTID,
  onLoad: process.env.VUE_APP_KEYCLOAK_OPTIONS_ONLOAD,
}


let keycloak = Keycloak(initOptions);

keycloak.init({ onLoad: 'login-required' }).then(async (auth) => {
  if (!auth) {
    window.location.reload();
  } else {
    console.info("Authenticated");

    await keycloak.loadUserInfo();

    const app = createApp(App);
    app.provide<KeycloakInstance>('keycloack', keycloak);
    app.use(router)
    app.use(store)
    app.use(CoreuiVue)
    app.provide('icons', icons)
    app.component('CIcon', CIcon)
    app.component('DocsCallout', DocsCallout)
    app.component('DocsExample', DocsExample)

    app.mount('#app');
    window.localStorage.setItem('keycloakToken', keycloak.token)
    console.log(keycloak.token);
    await router.push('/')
  }
});
