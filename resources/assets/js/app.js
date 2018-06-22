/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('datatables.net-bs');
window.moment = require('moment')

window.swal = require('sweetalert')

window.Vue = require('vue');

import Autocomplete from 'v2-autocomplete';

require('v2-autocomplete/dist/style/vue2-autocomplete.css');
Vue.component('autocomplete', Autocomplete);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('cost-centre-members', require('./components/CostCentreMembers.vue'));
Vue.component('providers-autocomplete', require('./components/ProvidersAutocomplete.vue'));


const app = new Vue({
  el: '#app',
  methods: {
    deleteAction(e) {
      const el = e.target;

      swal({
        title: "Atención",
        text: "Esta acción no se puede revertir.",
        icon: "info",
        buttons: {
          cancel: {
            value: false,
            visible: true
          },
          confirm: {
            value: true,
          }
        },
        dangerMode: true
      })
        .then(res => {
          if (!res) return;

          axios.delete(el.dataset.action)
            .then(res => {
              location.reload();
            })
            .catch(err => {
              swal('', 'Ocurrió un error inesperado.', 'danger')
            })
        })
    }
  }
});
