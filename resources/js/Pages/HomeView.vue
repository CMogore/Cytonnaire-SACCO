<!-- resources/js/Pages/HomeRoute.vue -->
<template>
    <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-4">
        <h1 class="text-2xl font-bold">HOME</h1>
        <router-link to="/test" class="text-blue-500">Take me to Test page</router-link>
        <button @click.prevent="triggerEndpoint" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Trigger Endpoint
        </button>
        <p v-if="response" class="text-gray-700">{{ response }}</p>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const response = ref();

const triggerEndpoint = async () => {
    try {
        const res = await axios.get('/api/test-me');
        response.value = res.data;
    } catch (error) {
        console.error(error);
    }
};
</script>
