

import {AgGridVue} from "ag-grid-vue";
import "ag-grid-community";

window.Vue = require('vue');

import vueStrap from 'vue-strap';

Vue.component('modal', vueStrap.modal);

window.axios = require('axios');

window.swal2 = require('sweetalert2');

Vue.component('ag-grid-vue', AgGridVue);


//Register Components
Vue.component('home', require('./components/HomePage.vue').default);
Vue.component('add', require('./components/Add.vue').default);
Vue.component('books-list', require('./components/BooksList.vue').default);


const app = new Vue({
    el: '#appcontent',
    data: {
        vueData: null
    }
});

window.app = app;

