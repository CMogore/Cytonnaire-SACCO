<template>
    <div class="bg-emerald-900 text-white h-full p-6">
      <h1 @click="selectMenuItem('home')" class=" py-2 px-4 text-center mb-2">Dashboard</h1>
      <ul class="text-center">
        <li @click="selectMenuItem('contributions')" :class="{ 'bg-gray-900': selectedMenuItem === 'contributions' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Contributions</li>
        <li @click="selectMenuItem('loans')" :class="{ 'bg-gray-900': selectedMenuItem === 'loans' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Loans</li>
        <li @click="selectMenuItem('statements')" :class="{ 'bg-gray-900': selectedMenuItem === 'statements' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Statements</li>
        

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
  