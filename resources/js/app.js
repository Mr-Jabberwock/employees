

require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('employees', require('./components/Employees.vue').default);

const app = new Vue({
    el: '#app',
});
