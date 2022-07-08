/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const createPosition = require('./modules/create-position-description').default
const updatePosition = require('./modules/update-position-description').default
const validatePosition = require('./modules/validate-position-description').default
const reportPosition = require('./modules/report-position-description').default

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('v-title', require('./components/VTitle.vue').default);
Vue.component('v-filter', require('./components/VFilter.vue').default);
Vue.component('v-write', require('./components/VWrite.vue').default);
Vue.component('v-roles', require('./components/VRoles.vue').default);
Vue.component('v-export-pdf', require('./components/VExportPDF.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.config.devtools = true;

const app = new Vue({
    el: '#app',
    mounted: function (){
        this.$nextTick(function() {
            createPosition()
            updatePosition()
            validatePosition()
            reportPosition()
        })
    }
});
