import {createRouter, createWebHistory} from 'vue-router'; 
//import Home from "../../views/Home";
import adminViews  from './admin-views';
import commonViews from './common-views'

const routes = Object.assign(commonViews.concat(adminViews));

const router = createRouter({
    history: createWebHistory(),
    routes

});

export default router;