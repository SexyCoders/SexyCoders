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
          store.data.tmp.lastResolvedEndpoint=response[endpoint];
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
    url: store.data.tmp.lastResolvedEndpoint,
    headers: {
      'Authorization': 'Bearer '+token
    },
    success:
    (response) =>
        {
          store.data.tmp.userinfo=response;
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
    url: store.datacenter.rest+"/resolve/company",
    success:
    (response) =>
        {
          store.data.tmp.userinfo=response;
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
    url: store.datacenter.rest+"/resolve/group",
    success:
    (response) =>
        {
          store.data.tmp.userinfo=response;
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
    url: store.datacenter.rest+"/etc/services",
    success:
    (response) =>
        {
          store.data.tmp.userinfo=response;
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
    app.use(router)
    app.use(store)
    store.DEBUG=process.env.VUE_APP_DEBUG;
    store.data={};
    store.data.tmp={};
    store.datacenter={};
    store.datacenter.rest=(store.DEBUG?"http://localhost:9000":"https://rest.uniclient.org");
    console.log("store init");

    window.localStorage.setItem('keycloakToken', keycloak.token)
    getUserInfo(keycloak.token);
    console.log(store.data.tmp.userinfo);

    resolveCompany(keycloak.token);
    console.log(store.data.tmp.userinfo);

    resolveGroup(keycloak.token);
    console.log(atob(store.data.tmp.userinfo));

    getServices(keycloak.token);
    console.log(atob(store.data.tmp.userinfo));

    var ta=[];
    ta.push('managers');
    ta.push('coders');
    console.log(ta);
    console.log(JSON.stringify(ta));

    app.use(CoreuiVue)
    app.provide('icons', icons)
    app.component('CIcon', CIcon)
    app.component('DocsCallout', DocsCallout)
    app.component('DocsExample', DocsExample)

    app.mount('#app');
    await router.push('/')
  }
});
