<template>
  <NavBar></NavBar>
  <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-4">
      <h1 class="text-2xl font-bold">HOME</h1>
      <router-link to="/test" class="text-blue-500">Take me to Test page</router-link>
      
      <button @click.prevent="logout" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          Logout
      </button>
      
  </div>
</template>

<script>
import NavBar from '../components/NavBar.vue';
import axios from 'axios';

export default {
  components: {
    NavBar
  },
  created() {
    // Check if user is authenticated
    if (!this.isAuthenticated) {
      // Redirect to login page or handle accordingly
      console.log('ziiiiii')
      this.$router.push('/');
    }
  },
  computed: {
    isAuthenticated() {
      // Check if user is authenticated by checking for a token
      return localStorage.getItem('auth_token');
    }
  },
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
                localStorage.removeItem('role_id');
                localStorage.removeItem('firstname');


                this.$router.push('/login');

            } catch (error) {
                console.error('Logout failed:', error.response.data);
            }
        },
        
    }
  

}
</script>

<style>

</style>