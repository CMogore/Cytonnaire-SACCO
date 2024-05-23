<template>
    <div class="text-black pt-20 border-r-2 border-gray h-full p-6">
      <ul class="text-center">
        <li @click="selectMenuItem('contributions')" :class="{ 'bg-emerald-900 text-white': selectedMenuItem === 'contributions' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Contributions</li>
        <li @click="selectMenuItem('loans')" :class="{ 'bg-emerald-900 text-white': selectedMenuItem === 'loans' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Loans</li>
        <li @click="selectMenuItem('latestpayments')" :class="{ 'bg-emerald-900 text-white': selectedMenuItem === 'latestpayments' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Payments</li>
        

        <!-- Add more menu items as needed -->
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        selectedMenuItem: 'contributions' // Default selected menu item
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
  