/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import '../css/app.css';

window.Vue = require('vue').default;
import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect);
import vSelect from 'vue-select'

// vue-select
Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';
// data picker
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
Vue.component('DatePicker', DatePicker)

//loader component
import Loader from './components/global/Loader';
Vue.component('Loader', Loader)
// ek editor
import CKEditor from 'ckeditor4-vue';
Vue.use( CKEditor );



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('requisition-form', require('./components/requisitions/Form.vue').default);
Vue.component('file-upload', require('./components/requisitions/FileUpload').default);
Vue.component('requisition-view', require('./components/requisitions/RequisitionView').default);
Vue.component('purchase-order-form', require('./components/purchase-order/Form').default);
Vue.component('grn-form', require('./components/goods-receivable-note/Form.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
