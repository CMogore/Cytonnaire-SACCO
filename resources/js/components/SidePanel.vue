<template>
  <button @click="toggleMenu" class="block md:hidden -mt-[43rem]">
    <ion-icon  name="menu" class="text-3xl cursor-pointer text-white"></ion-icon>

      </button>
  <div :class="{'block': isMenuOpen, 'hidden': !isMenuOpen, 'md:block': true}" class="bg-emerald-900 text-white h-full p-6 -ml-8 -md:ml-2 md:pl-12 text-center">
    <div class="flex justify-between items-center mb-4">
      <h1 @click="selectMenuItem('home')" class="text-2xl font-semibold cursor-pointer">Admin Panel</h1>
      
    </div>
    <ul  class="text-center">
      <li @click="selectMenuItem('users')" :class="{ 'bg-gray-900': selectedMenuItem === 'users' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Users</li>
      <li @click="selectMenuItem('contributions')" :class="{ 'bg-gray-900': selectedMenuItem === 'contributions' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Contributions</li>
      <li @click="selectMenuItem('loanrequests')" :class="{ 'bg-gray-900': selectedMenuItem === 'loanrequests' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Loan Requests</li>
      <li @click="selectMenuItem('statuses')" :class="{ 'bg-gray-900': selectedMenuItem === 'statuses' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Statuses</li>
      <li @click="selectMenuItem('roles')" :class="{ 'bg-gray-900': selectedMenuItem === 'roles' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Roles</li>
      <li @click="selectMenuItem('loantypes')" :class="{ 'bg-gray-900': selectedMenuItem === 'loantypes' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Loan Types</li>
      <li @click="selectMenuItem('loanpayments')" :class="{ 'bg-gray-900': selectedMenuItem === 'loanpayments' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Loan Payments</li>
      <li @click="selectMenuItem('loans')" :class="{ 'bg-gray-900': selectedMenuItem === 'loans' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Loans</li>
      <li @click="selectMenuItem('shares')" :class="{ 'bg-gray-900': selectedMenuItem === 'shares' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Shares</li>
      <li @click="selectMenuItem('sharetransfers')" :class="{ 'bg-gray-900': selectedMenuItem === 'sharetransfers' }" class="py-2 px-4 mb-2 rounded cursor-pointer">Share Transfers</li>
      <li class="py-2 px-4 mb-2 rounded cursor-pointer">
        <router-link to="/member" class="text-white no-underline">Member</router-link>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  data() {
    return {
      selectedMenuItem: 'home', // Default selected menu item
      isMenuOpen: false // Track menu open state
    };
  },
  methods: {
    selectMenuItem(item) {
      this.selectedMenuItem = item;
      this.isMenuOpen = false; // Close menu on item select
      this.$emit('menuItemSelected', item); // Emit event to parent component (AdminDashboard.vue)
    },
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    }
  }
};
</script>

