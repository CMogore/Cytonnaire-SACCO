<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
      <div class="p-6 bg-white shadow-md rounded-md max-w-lg w-full">
        <div class="flex justify-between bg-white text-center mb-6 mx-2 mr-4">
          <a
            :class="{ 'bg-emerald-900 text-white': activeForm === 'login' }"
            @click.prevent="activeForm = 'login'"
            href="#"
            class="text-sm font-semibold py-2 md:px-24 px-14 focus:outline-none transition-colors duration-300 ease-in-out hover:bg-gray-100 hover:text-white"
          >
            Login
          </a>
          <a
            :class="{ 'bg-emerald-900 text-white': activeForm === 'signup' }"
            @click.prevent="activeForm = 'signup'"
            href="#"
            class="text-sm font-semibold py-2 md:pr-[4.9rem] px-14 md:pl-20 focus:outline-none transition-colors duration-300 ease-in-out hover:bg-gray-100 hover:text-white"
          >
            Sign Up
          </a>
        </div>
  
        <!-- Login Form -->
        <div v-if="activeForm === 'login'">
          <h2 class="text-4xl font-semibold mb-6 text-emerald-900 text-center">Login</h2>
          <form @submit.prevent="login">
            <div class="mb-4">
              <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
              <input type="text" id="email" v-model="loginForm.email" required class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-6">
              <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
              <input type="password" id="password" v-model="loginForm.password" required class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:border-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 focus:outline-none transition-colors duration-300 ease-in-out">Login</button>
          </form>
        </div>
  
        <!-- Sign Up Form -->
        <div v-if="activeForm === 'signup'">
          <h2 class="text-4xl font-semibold mb-6 text-emerald-900 text-center">Sign Up</h2>
          <form @submit.prevent="signup">
            <div class="mb-4">
              <label for="newFirstname" class="block text-sm font-medium text-gray-700 mb-2">FirstName</label>
              <input type="text" id="newFirstname" v-model="signupForm.firstname" required class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
              <label for="newLastname" class="block text-sm font-medium text-gray-700 mb-2">LastName</label>
              <input type="text" id="newLastname" v-model="signupForm.lastname" required class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
              <label for="newEmail" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
              <input type="email" id="newEmail" v-model="signupForm.email" required class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
              <label for="newNumber" class="block text-sm font-medium text-gray-700 mb-2">Number</label>
              <input type="text" id="newNumber" v-model="signupForm.number" required class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
              <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
              <input type="password" id="newPassword" v-model="signupForm.password" required class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:border-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 focus:outline-none transition-colors duration-300 ease-in-out">Sign Up</button>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  export default {
    data() {
      return {
        activeForm: 'login',
        loginForm: {
          email: '',
          password: ''
        },
        signupForm: {
          firstname: '',
          lastname: '',
          email: '',
          number: '',
          password: '',
          confirmPassword: ''
        }
      };
    },
    methods: {
      async login() {
            try {
                const response = await axios.post('/api/login', this.loginForm);
                console.log('Logged in:', response.data);
                localStorage.setItem('auth_token', response.data.token);
                localStorage.setItem('role_id', response.data.user.role_id);
                localStorage.setItem('firstname', response.data.user.firstname);

                this.$router.push('/member');
            } catch (error) {
                console.error('Login failed:', error.response.data.error);
            }
        },
        async signup() {
            try {
                const response = await axios.post('/api/register', this.signupForm);
                console.log('Registered:', response.data);
                localStorage.setItem('auth_token', response.data.token);
                this.$router.push('/login');
            } catch (error) {
                console.error('Registration failed:', error.response.data.error);
            }
        }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles here */
  </style>
  