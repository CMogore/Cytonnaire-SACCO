<!-- resources/js/Pages/HomeRoute.vue -->
<template>
    <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-4">
        <h1 class="text-2xl font-bold">HOME</h1>
        <router-link to="/test" class="text-blue-500">Take me to Test page</router-link>
        <button @click.prevent="triggerEndpoint" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Trigger Endpoint
        </button>
        <button @click.prevent="logout" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Logout
        </button>
        <p v-if="response" class="text-gray-700">{{ response }}</p>
    </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

const response = ref();

// const triggerEndpoint = async () => {
//     try {
//         const res = await axios.get('/api/test-me');
//         response.value = res.data;
//     } catch (error) {
//         console.error(error);
//     }
// };
export default {
    methods: {
      async logout() {
            try {
                const token = localStorage.getItem('auth_token');
                const response = await axios.post('/api/logout', {}, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
                });
                console.log('yess worked')
                console.log('Logged out:', response.data);
                localStorage.removeItem('auth_token');
                this.$router.push('/login');

            } catch (error) {
                console.error('Logout failed:', error.response.data);
            }
        },
        
    }
}
</script>
