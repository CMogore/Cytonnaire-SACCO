<template>
  <header class="bg-emerald-900 p-4 text-lg text-white font-bold md:sticky md:top-0 md:z-50">
    <nav class="flex justify-between items-center w-[92%] mx-auto">
      <!-- Brand Logo -->
      <div class="font-bold text-2xl pr-12">CYSACCO</div>
      
      <!-- Navigation Links Container -->
      <div class="flex items-center justify-between w-full">
        <!-- Left Navigation Links -->
        <ul class="flex space-x-12">
          <li><router-link to="/" class="hover:text-gray-500">Home</router-link></li>
          <li><router-link to="/about" class="hover:text-gray-500">About</router-link></li>
        </ul>

        <!-- Right Authentication Links -->
        <ul class="flex items-center space-x-4 ml-auto">
          <li v-if="isAuthenticated" class="flex items-center space-x-4">
            <span>{{ name }}</span>
            <button @click="logout" class="hover:text-gray-500">Logout</button>
          </li>
          <li v-else class="flex space-x-4">
            <router-link to="/login" class="hover:text-gray-500">Login</router-link>
            <span class="hidden md:inline">|</span>
            <router-link to="/signup" class="hover:text-gray-500">Signup</router-link>
          </li>
        </ul>
      </div>

      <!-- Mobile Menu Icon -->
      <div class="flex items-center md:hidden">
        <ion-icon @click="toggleMenu" name="menu" class="text-3xl cursor-pointer text-white"></ion-icon>
      </div>
    </nav>
  </header>
</template>
  <script>
  export default {
    data() {
      return {
        isMenuOpen: false,
        isAuthenticated: false, // Placeholder for authentication status
        name: '', // Placeholder for authenticated user's name
      };
    },
    created() {
      this.checkAuthentication();
    },
    methods: {
      toggleMenu() {
        this.isMenuOpen = !this.isMenuOpen;
      },
      checkAuthentication() {
        const authToken = localStorage.getItem('auth_token');
        if (authToken) {
          this.isAuthenticated = true;
          this.name = localStorage.getItem('firstname'); // Assume user name is stored in localStorage
        }
      },
      async logout() {
        try {
          const authToken = localStorage.getItem('auth_token');
          await axios.post('/api/logout', {}, {
            headers: { Authorization: `Bearer ${authToken}` }
          });
          localStorage.removeItem('auth_token');
          localStorage.removeItem('firstname');
          localStorage.removeItem('role_id');

          this.isAuthenticated = false;
          this.name = '';
          this.$router.push('/');
        } catch (error) {
          console.error('Logout failed:', error);
        }
      }
    }
  };
  </script>
  
  
  