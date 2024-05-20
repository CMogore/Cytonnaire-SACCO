import { createRouter, createWebHistory } from "vue-router";
import HomeView from '../Pages/HomeView.vue'
import TestView from '../Pages/TestView.vue'


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
];

export default createRouter({
    history: createWebHistory(),
    routes,
});