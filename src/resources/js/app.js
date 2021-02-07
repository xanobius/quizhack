require('./bootstrap');

import Vue from 'vue'

Vue.component('wstest', require('./components/WSTest.vue').default)
Vue.component('player-view', require('./components/PlayerView').default)
Vue.component('moderator-view', require('./components/ModeratorView').default)

const app = new Vue({
    el : '#app',
})
