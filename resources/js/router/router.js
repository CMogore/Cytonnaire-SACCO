import { createRouter, createWebHistory } from "vue-router";
import HomeView from '../Pages/HomeView.vue'
import TestView from '../Pages/TestView.vue'
import LoginSignup from '../Pages/LoginSignup.vue'
import Admin from '../Pages/AdminDashboard.vue'
import Member from '../Pages/UserDashboard.vue'





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
    {
        path: '/admin',
        name: Admin,
        component:Admin
    },
    {
        path: '/member',
        name: Member,
        component:Member
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});