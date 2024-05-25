<!-- resources/js/Pages/HomeRoute.vue -->
<template>
    <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-4">
        <h1 class="text-2xl font-bold">HOME</h1>
        <router-link to="/test" class="text-blue-500">Take me to Test page</router-link>
        
        
        
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue';


export default {
    components: {
        NavBar
    }
}




</script>
