import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import CoreuiVue from '@coreui/vue'
import CIcon from '@coreui/icons-vue'
import { iconsSet as icons } from '@/assets/icons'
import DocsCallout from '@/components/DocsCallout'
import DocsExample from '@/components/DocsExample'
import $ from "jquery";

import Keycloak, { KeycloakConfig, KeycloakInstance } from 'keycloak-js';

//KEYCLOAK
//


function resolveApiEndpoint(endpoint){
  $.ajax({
    type: 'GET',
    url: "http://localhost:8989/realms/testing/.well-known/openid-configuration",
    success:
    (response) =>
        {
          store.tmp.lastResolvedEndpoint=response[endpoint];
        },
    error:
    (response) =>
          {
            alert("Api could not be resolved!\nPlease reach out to the system admin!");
          },
      async:false
      });
};
function getUserInfo(token){
  resolveApiEndpoint('userinfo_endpoint');
  $.ajax({
    type: 'GET',
    url: store.tmp.lastResolvedEndpoint,
    headers: {
      'Authorization': 'Bearer '+token
    },
    success:
    (response) =>
        {
          store.etc.user=response;
        },
    error:
    (response) =>
          {
          },
      async:false
      });

};
function resolveCompany(token)
  {
    var send={};
    send.token=token;
    send=btoa(JSON.stringify(send));
  $.ajax({
    type: 'POST',
    data: send, 
    url: store.etc.rest+"/resolve/company",
    success:
    (response) =>
        {
          store.etc.company=JSON.parse(atob(response)).company;
        },
    error:
    (response) =>
          {
          },
      async:false
      });
  }
function resolveGroup(token)
  {
    var send={};
    send.token=token;
    send=btoa(JSON.stringify(send));
  $.ajax({
    type: 'POST',
    data: send, 
    url: store.etc.rest+"/resolve/group",
    success:
    (response) =>
        {
          store.etc.group=JSON.parse(atob(response)).groups;
        },
    error:
    (response) =>
          {
          },
      async:false
      });
  }

function getServices(token)
  {
    var send={};
    send.token=token;
    send=btoa(JSON.stringify(send));
  $.ajax({
    type: 'POST',
    data: send, 
    url: store.etc.rest+"/etc/services",
    success:
    (response) =>
        {
          store.etc.services=JSON.parse(atob(response)).services;
        },
    error:
    (response) =>
          {
          },
      async:false
      });
  }

function getDatabases(token)
  {
    var send={};
    send.token=token;
    send=btoa(JSON.stringify(send));
  $.ajax({
    type: 'POST',
    data: send, 
    url: store.etc.rest+"/etc/databases",
    success:
    (response) =>
        {
          store.etc.databases=JSON.parse(atob(response)).databases;
        },
    error:
    (response) =>
          {
          },
      async:false
      });
  }

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
    app.use(store)
    store.DEBUG=process.env.VUE_APP_DEBUG;
    store.etc={};
    store.etc.rest=(store.DEBUG?"http://localhost:9000":"https://rest.uniclient.org");
    store.etc.token=keycloak.token;
    store.tmp={};
    store.data={};
    console.log("store init");

    window.localStorage.setItem('keycloakToken', keycloak.token)
    getUserInfo(keycloak.token);
    console.log(JSON.stringify(store.etc.user));

    resolveCompany(keycloak.token);
    console.log(JSON.stringify(store.etc.company));

    resolveGroup(keycloak.token);
    console.log(JSON.stringify(store.etc.group));

    getServices(keycloak.token);
    console.log(JSON.stringify(store.etc.services));

    getDatabases(keycloak.token);
    console.log(JSON.stringify(store.etc.databases));

    app.use(router)
    app.use(CoreuiVue)
    app.provide('icons', icons)
    app.component('CIcon', CIcon)
    app.component('DocsCallout', DocsCallout)
    app.component('DocsExample', DocsExample)

    app.mount('#app');
    await router.push('/')
  }
});
