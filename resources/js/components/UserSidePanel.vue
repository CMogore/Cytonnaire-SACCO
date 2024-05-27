<template>
  <div>
    <!-- Hamburger Icon for Small Screens -->
    <div class="md:hidden p-4 flex justify-between items-center bg-emerald-900 text-white">
      <button @click="toggleMenu" class="focus:outline-none -mt-[5.5rem] -ml-3">
        <ion-icon  name="menu" class="text-3xl cursor-pointer text-white"></ion-icon>

      </button>
    </div>

    <!-- Sidebar Menu -->
    <div :class="{'block': isMenuOpen, 'hidden': !isMenuOpen}" class="md:block bg-emerald-900 text-white h-full p-6">
      <h1 @click="selectMenuItem('home')" class="py-2 px-4 text-center mb-2 text-2xl font-semibold cursor-pointer">
        Dashboard
      </h1>
      <ul class="text-center space-y-2">
        <li @click="selectMenuItem('contributions')" 
            :class="{ 'bg-gray-900': selectedMenuItem === 'contributions' }" 
            class="py-2 px-4 mb-2 rounded cursor-pointer">
          Contributions
        </li>
        <li @click="selectMenuItem('loans')" 
            :class="{ 'bg-gray-900': selectedMenuItem === 'loans' }" 
            class="py-2 px-4 mb-2 rounded cursor-pointer">
          Loans
        </li>
        <li @click="selectMenuItem('statements')" 
            :class="{ 'bg-gray-900': selectedMenuItem === 'statements' }" 
            class="py-2 px-4 mb-2 rounded cursor-pointer">
          Statements
        </li>
        <!-- Add more menu items as needed -->
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      selectedMenuItem: 'home', // Default selected menu item
      isMenuOpen: false // State to track the menu's visibility
    };
  },
  methods: {
    selectMenuItem(item) {
      this.selectedMenuItem = item;
      this.$emit('menuItemSelected', item); // Emit event to parent component (AdminDashboard.vue)
      this.isMenuOpen = false; // Close menu after selection
    },
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    }
  }
};
</script>

