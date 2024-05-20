<template>
    <div>
        <h1>HOME</h1>
        <router-link to="/test">Take me to Test page</router-link>
        <button @click.prevent="triggerEndpoint">Trigger Endpoint</button>
        <p v-if="response">{{ response }}</p>
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
