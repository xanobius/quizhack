require('./bootstrap');

import Vue from 'vue'

Vue.component('wstest', require('./components/WSTest.vue').default)
Vue.component('player-view', require('./components/PlayerView').default)

const app = new Vue({
    el : '#app',
})
