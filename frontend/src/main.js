import 'bootstrap'; 
import 'bootstrap/dist/css/bootstrap.min.css'

import { createApp } from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core';
import { faBars, faArrowLeft } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import VueTheMask from 'vue-the-mask'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import App from './App.vue'
import router from "../src/routes/router"

library.add(faBars, faArrowLeft)

createApp(App)
.component('fa', FontAwesomeIcon)
    .use(router)
    .use(VueTheMask)
    .use(VueSweetalert2)
    .mount('#app')
