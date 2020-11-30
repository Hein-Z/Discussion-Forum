/*
|----------------------------------------------------------------
| Vue 2
|----------------------------------------------------------------
*/

import {App, plugin} from '@inertiajs/inertia-vue'
import Vue from 'vue'

import Toastr from "vue-toastr";

Vue.mixin({methods: {route: window.route}})
Vue.use(Toastr);

Vue.use(plugin)

const el = document.getElementById('app')

new Vue({
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => require(`./Pages/${name}`).default,
        },
    }),
}).$mount(el)
