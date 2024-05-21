import { createRouter, createWebHistory } from "vue-router";
import HomeView from '../Pages/HomeView.vue'
import TestView from '../Pages/TestView.vue'
import LoginSignup from '../Pages/LoginSignup.vue'



const routes = [
    {
        path: '/',
        name: HomeView,
        component:HomeView
    },
    {
        path: '/test',
        name: TestView,
        component:TestView
    },
    {
        path: '/login',
        name: LoginSignup,
        component:LoginSignup
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});