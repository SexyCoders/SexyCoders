import { h, resolveComponent } from 'vue'
import { createRouter, createWebHashHistory } from 'vue-router'

import MainApp from '../../src/App.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: MainApp,
    redirect: '/home',
    children: [
      {
        path: '/home',
        name: 'Dashboard',
        meta: {
          title: 'Home Page - Example App',
          metaTags: [
            {
              name: 'Home - UniClient',
              content: 'UniClient app homepage.'
            },
            {
              property: 'og:description',
              content: 'UniClient app homepage.'
            }
          ]
        },
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
          import(/* webpackChunkName: "dashboard" */ '@/views/Dashboard.vue'),
      },
      {
        path: '/services/:service_name',
        name: 'Services',
      },
      {
        path: '/databases/:database_name',
        name: 'Databases',
        component: () =>
          import(/* webpackChunkName: "dashboard" */ '../components/Database.vue'),
      },
      {
        path: '/create/database',
        name: 'create_database',
        component: () =>
          import(/* webpackChunkName: "dashboard" */ '../components/databases/create.vue'),
      },
      {
        path: '/create/user',
        name: 'create_user',
        component: () =>
          import(/* webpackChunkName: "dashboard" */ '../components/users/create.vue'),
      },
      //{
        //path: '/theme/colors',
        //name: 'Colors',
        //component: () => import('@/views/theme/Colors.vue'),
      //},
      //{
        //path: '/theme/typography',
        //name: 'Typography',
        //component: () => import('@/views/theme/Typography.vue'),
      //},
      //{
        //path: '/base',
        //name: 'Base',
        //component: {
          //render() {
            //return h(resolveComponent('router-view'))
          //},
        //},
        //redirect: '/base/breadcrumbs',
        //children: [
          //{
            //path: '/base/accordion',
            //name: 'Accordion',
            //component: () => import('@/views/base/Accordion.vue'),
          //},
          //{
            //path: '/base/breadcrumbs',
            //name: 'Breadcrumbs',
            //component: () => import('@/views/base/Breadcrumbs.vue'),
          //},
          //{
            //path: '/base/cards',
            //name: 'Cards',
            //component: () => import('@/views/base/Cards.vue'),
          //},
          //{
            //path: '/base/carousels',
            //name: 'Carousels',
            //component: () => import('@/views/base/Carousels.vue'),
          //},
          //{
            //path: '/base/collapses',
            //name: 'Collapses',
            //component: () => import('@/views/base/Collapses.vue'),
          //},
          //{
            //path: '/base/list-groups',
            //name: 'List Groups',
            //component: () => import('@/views/base/ListGroups.vue'),
          //},
          //{
            //path: '/base/navs',
            //name: 'Navs',
            //component: () => import('@/views/base/Navs.vue'),
          //},
          //{
            //path: '/base/paginations',
            //name: 'Paginations',
            //component: () => import('@/views/base/Paginations.vue'),
          //},
          //{
            //path: '/base/placeholders',
            //name: 'Placeholders',
            //component: () => import('@/views/base/Placeholders.vue'),
          //},
          //{
            //path: '/base/popovers',
            //name: 'Popovers',
            //component: () => import('@/views/base/Popovers.vue'),
          //},
          //{
            //path: '/base/progress',
            //name: 'Progress',
            //component: () => import('@/views/base/Progress.vue'),
          //},
          //{
            //path: '/base/spinners',
            //name: 'Spinners',
            //component: () => import('@/views/base/Spinners.vue'),
          //},
          //{
            //path: '/base/tables',
            //name: 'Tables',
            //component: () => import('@/views/base/Tables.vue'),
          //},
          //{
            //path: '/base/tooltips',
            //name: 'Tooltips',
            //component: () => import('@/views/base/Tooltips.vue'),
          //},
        //],
      //},
      //{
        //path: '/buttons',
        //name: 'Buttons',
        //component: {
          //render() {
            //return h(resolveComponent('router-view'))
          //},
        //},
        //redirect: '/buttons/standard-buttons',
        //children: [
          //{
            //path: '/buttons/standard-buttons',
            //name: 'Buttons',
            //component: () => import('@/views/buttons/Buttons.vue'),
          //},
          //{
            //path: '/buttons/dropdowns',
            //name: 'Dropdowns',
            //component: () => import('@/views/buttons/Dropdowns.vue'),
          //},
          //{
            //path: '/buttons/button-groups',
            //name: 'Button Groups',
            //component: () => import('@/views/buttons/ButtonGroups.vue'),
          //},
        //],
      //},
      //{
        //path: '/forms',
        //name: 'Forms',
        //component: {
          //render() {
            //return h(resolveComponent('router-view'))
          //},
        //},
        //redirect: '/forms/form-control',
        //children: [
          //{
            //path: '/forms/form-control',
            //name: 'Form Control',
            //component: () => import('@/views/forms/FormControl.vue'),
          //},
          //{
            //path: '/forms/select',
            //name: 'Select',
            //component: () => import('@/views/forms/Select.vue'),
          //},
          //{
            //path: '/forms/checks-radios',
            //name: 'Checks & Radios',
            //component: () => import('@/views/forms/ChecksRadios.vue'),
          //},
          //{
            //path: '/forms/range',
            //name: 'Range',
            //component: () => import('@/views/forms/Range.vue'),
          //},
          //{
            //path: '/forms/input-group',
            //name: 'Input Group',
            //component: () => import('@/views/forms/InputGroup.vue'),
          //},
          //{
            //path: '/forms/floating-labels',
            //name: 'Floating Labels',
            //component: () => import('@/views/forms/FloatingLabels.vue'),
          //},
          //{
            //path: '/forms/layout',
            //name: 'Layout',
            //component: () => import('@/views/forms/Layout.vue'),
          //},
          //{
            //path: '/forms/validation',
            //name: 'Validation',
            //component: () => import('@/views/forms/Validation.vue'),
          //},
        //],
      //},
      //{
        //path: '/charts',
        //name: 'Charts',
        //component: () => import('@/views/charts/Charts.vue'),
      //},
      //{
        //path: '/icons',
        //name: 'Icons',
        //component: {
          //render() {
            //return h(resolveComponent('router-view'))
          //},
        //},
        //redirect: '/icons/coreui-icons',
        //children: [
          //{
            //path: '/icons/coreui-icons',
            //name: 'CoreUI Icons',
            //component: () => import('@/views/icons/CoreUIIcons.vue'),
          //},
          //{
            //path: '/icons/brands',
            //name: 'Brands',
            //component: () => import('@/views/icons/Brands.vue'),
          //},
          //{
            //path: '/icons/flags',
            //name: 'Flags',
            //component: () => import('@/views/icons/Flags.vue'),
          //},
        //],
      //},
      //{
        //path: '/notifications',
        //name: 'Notifications',
        //component: {
          //render() {
            //return h(resolveComponent('router-view'))
          //},
        //},
        //redirect: '/notifications/alerts',
        //children: [
          //{
            //path: '/notifications/alerts',
            //name: 'Alerts',
            //component: () => import('@/views/notifications/Alerts.vue'),
          //},
          //{
            //path: '/notifications/badges',
            //name: 'Badges',
            //component: () => import('@/views/notifications/Badges.vue'),
          //},
          //{
            //path: '/notifications/modals',
            //name: 'Modals',
            //component: () => import('@/views/notifications/Modals.vue'),
          //},
        //],
      //},
      //{
        //path: '/widgets',
        //name: 'Widgets',
        //component: () => import('@/views/widgets/Widgets.vue'),
      //},
    ],
  },
  {
    path: '/pages',
    redirect: '/pages/404',
    name: 'Pages',
    component: {
      render() {
        return h(resolveComponent('router-view'))
      },
    },
    children: [
      {
        path: '404',
        name: 'Page404',
        component: () => import('@/views/pages/Page404'),
      },
      {
        path: '500',
        name: 'Page500',
        component: () => import('@/views/pages/Page500'),
      },
      {
        path: 'login',
        name: 'Login',
        component: () => import('@/views/pages/Login'),
      },
      {
        path: 'register',
        name: 'Register',
        component: () => import('@/views/pages/Register'),
      },
    ],
  },
]

const router = createRouter({
  history: createWebHashHistory(process.env.BASE_URL),
  routes,
  scrollBehavior() {
    // always scroll to top
    return { top: 0 }
  },
})

// ...

//// This callback runs before every route change, including on page load.
//router.beforeEach((to, from, next) => {
  //// This goes through the matched routes from last to first, finding the closest route with a title.
  //// e.g., if we have `/some/deep/nested/route` and `/some`, `/deep`, and `/nested` have titles,
  //// `/nested`'s will be chosen.
  //const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);

  //// Find the nearest route element with meta tags.
  //const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);

  //const previousNearestWithMeta = from.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);

  //// If a route with a title was found, set the document (page) title to that value.
  //if(nearestWithTitle) {
    //document.title = nearestWithTitle.meta.title;
  //} else if(previousNearestWithMeta) {
    //document.title = previousNearestWithMeta.meta.title;
  //}

  //// Remove any stale meta tags from the document using the key attribute we set below.
  //Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el));

  //// Skip rendering meta tags if there are none.
  //if(!nearestWithMeta) return next();

  //// Turn the meta tag definitions into actual elements in the head.
  //nearestWithMeta.meta.metaTags.map(tagDef => {
    //const tag = document.createElement('meta');

    //Object.keys(tagDef).forEach(key => {
      //tag.setAttribute(key, tagDef[key]);
    //});

    //// We use this to track which meta tags we create so we don't interfere with other ones.
    //tag.setAttribute('data-vue-router-controlled', '');

    //return tag;
  //})
  //// Add the meta tags to the document head.
  //.forEach(tag => document.head.appendChild(tag));

  //next();
//});

// ...

export default router
