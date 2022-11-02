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

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { fas } from '@fortawesome/free-solid-svg-icons';
library.add(fas);

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import { plugin as vueMetaPlugin } from 'vue-meta'
//import VueMeta from 'vue-meta'


function resolveApiEndpoint(endpoint)
{
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
            onAuthError();
            alert("Api could not be resolved!\nPlease reach out to the system admin!");
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
                    onAuthError();
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
                    onAuthError();
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
                    onAuthError();
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
            //onAuthError();
          },
      async:false
      });
  }

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
                    onAuthError();
          },
      async:false
      });

};


    const checkToken=function(){
        keycloak.updateToken(70).then((refreshed) => {
          if (refreshed)
            console.log('Token refreshed' + refreshed);
        }).catch(() => {
          console.log('Failed to refresh token');
          return 1;
        });
        return 0;
      }//'this is a plugin test' //this.$gPluginFun()

    const onAuthError=function(){
      window.location.reload();
    }



const initOptions = {
  url: process.env.VUE_APP_KEYCLOAK_OPTIONS_URL,
  realm: process.env.VUE_APP_KEYCLOAK_OPTIONS_REALM,
  clientId: process.env.VUE_APP_KEYCLOAK_OPTIONS_CLIENTID,
  onLoad: process.env.VUE_APP_KEYCLOAK_OPTIONS_ONLOAD,
}


let keycloak = Keycloak(initOptions);

function main(){
    console.info("Authenticated");

    keycloak.loadUserInfo();

    const app = createApp(App);
    app.provide<KeycloakInstance>('keycloack', keycloak);
    app.use(store)
    store.DEBUG=process.env.VUE_APP_DEBUG;
    store.etc={};
    store.etc.rest=(store.DEBUG?"http://localhost:9000":"https://rest.uniclient.org");
    store.etc.token=keycloak.token;
    store.tmp={};
    store.data={};
    store.proc={};
    store.proc.layout={};
    store.proc.layout.sidebar=true;
    store.proc.layout.header=true;
    store.proc.layout.footer=true;

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
    app.use(VueSweetalert2);
    app.use(vueMetaPlugin,{refreshOnceOnNavigation: true});
    app.provide('icons', icons)
    app.component('CIcon', CIcon)
    app.component('DocsCallout', DocsCallout)
    app.component('DocsExample', DocsExample)
    app.component('font-awesome-icon', FontAwesomeIcon)
    app.provide('$checkToken',checkToken);
    app.provide('$onAuthError',onAuthError);

  setInterval(() => {
    checkToken();
  }, 3000)

    app.mount('#app');
    router.push('/')
}
keycloak.init({ onLoad: 'login-required' }).then((auth) => {
  if (!auth)
    window.location.reload();
  else 
    main();
});
