<template>
    <div class="bg-emerald-900 text-white h-full p-6">
      <h1 @click="selectMenuItem('home')" class="text-2xl font-semibold mb-4">Admin Panel</h1>
      <ul class="text-center">
        <li @click="selectMenuItem('users')" :class="{ 'bg-gray-900': selectedMenuItem === 'users' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Users</li>
        <li @click="selectMenuItem('contributions')" :class="{ 'bg-gray-900': selectedMenuItem === 'contributions' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Contributions</li>
        <li @click="selectMenuItem('loanrequests')" :class="{ 'bg-gray-900': selectedMenuItem === 'loanrequests' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Loan Requests</li>
        <li @click="selectMenuItem('statuses')" :class="{ 'bg-gray-900': selectedMenuItem === 'statuses' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Statuses</li>
        <li @click="selectMenuItem('movieactors')" :class="{ 'bg-gray-900': selectedMenuItem === 'movieactors' }" class="py-2 px-4 mb-2 rounded cursor-pointer">MovieActors</li>
        <li @click="selectMenuItem('moviegenres')" :class="{ 'bg-gray-900': selectedMenuItem === 'moviegenres' }" class="py-2 px-4 mb-2 rounded cursor-pointer">MovieGenres</li>
        <li class="py-2 px-4 mb-2 rounded cursor-pointer"><router-link to ="/member" > Member</router-link></li>


        <!-- Add more menu items as needed -->
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        selectedMenuItem: 'home' // Default selected menu item
      };
    },
    methods: {
      selectMenuItem(item) {
        this.selectedMenuItem = item;
        // Emit event or perform action to switch content based on selected menu item
        this.$emit('menuItemSelected', item); // Emit event to parent component (AdminDashboard.vue)
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>
  