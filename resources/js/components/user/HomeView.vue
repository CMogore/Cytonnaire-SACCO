<template>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-2 ml-16 px-12 ">
      <div @click="openModal"> 
      <div  class="bg-orange-500 rounded-lg p-12  mb-2 h-10 w-10 flex items-center justify-center">
        <div class="text-center">
          <h2 class="text-2xl font-bold mb-2 text-white">BS</h2>
        </div>
      </div>
      <h2 class="text-l font-semibold mb-2">Buy Shares</h2>
    </div> 
    <div @click="openMCModal"> 
      <div  class="bg-teal-500 rounded-lg p-12 ml-4 mb-2 h-10 w-10 flex items-center justify-center">
        <div class="text-center">
          <h2 class="text-2xl font-bold mb-2 text-white">MC</h2>
        </div>
      </div>
      <h2 class="text-l font-semibold mb-2">Make Contributions</h2>
    </div> 
    <div @click="openLPModal"> 
      <div  class="bg-pink-500 rounded-lg p-12  mb-2 h-10 w-10 flex items-center justify-center">
        <div class="text-center">
          <h2 class="text-2xl font-bold mb-2 text-white">LP</h2>
        </div>
      </div>
      <h2 class="text-l font-semibold mb-2">Loan Payments</h2>
    </div> 
    <div @click="openSTModal"> 
      <div  class="bg-fuchsia-500 rounded-lg p-12 ml-2 mb-2 h-10 w-10 flex items-center justify-center">
        <div class="text-center">
          <h2 class="text-2xl font-bold mb-2 text-white">ST</h2>
        </div>
      </div>
      <h2 class="text-l font-semibold mb-2">Transfer Shares</h2>
    </div> 
    </div>
    <BuySharesModal :isOpen="isModalOpen" :userId="userId" @close="closeModal" @shareBought="handleShareBought" />
    <MakeContributionsModal :isOpen="isMakeContributionsModalOpen" @close="isMakeContributionsModalOpen = false" @contributionMade="handleContributionMade" />

    <div class="flex h-[24rem] mt-20 rounded shadow-emerald-900 shadow-2xl">
      <!-- Side panel -->
      <HomePanel @menuItemSelected="handleMenuItemSelected" />

      <!-- Main content area -->
      <div class="flex-1 p-6 bg-gray-100">
        <div v-if="selectedMenuItem === 'contributions'">
          <h2 class="text-2xl font-semibold mb-4">Contributions</h2>
        </div>
        <div v-else-if="selectedMenuItem === 'loans'">
          <h2 class="text-2xl font-semibold mb-4">Loans Table</h2>
        </div>
        <div v-else-if="selectedMenuItem === 'statements'">
          <h2 class="text-2xl font-semibold mb-4">Statements</h2>
        </div>
        <!-- Add more sections for other menu items -->
      </div>
    </div>

</template>

<script>
import HomePanel from './HomePanel.vue';
import BuySharesModal from './BuyShares.vue';
import MakeContributionsModal from './MakeContribution.vue';

export default {
  components: {
    HomePanel,
    BuySharesModal,
    MakeContributionsModal,
  },
  data() {
    return {
      selectedMenuItem: 'home',
      isMakeContributionsModalOpen: false,
      isModalOpen: false,
      userId: null // Replace with actual user ID retrieval logic
    };
  },
  created() {
    this.userId = this.getUserIdFromLocalStorage(); // Retrieve user ID from localStorage or other source
  },
  methods: {
    handleMenuItemSelected(item) {
      this.selectedMenuItem = item;
    },
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    openMCModal() {
      this.isMakeContributionsModalOpen = true;
    },
    handleShareBought() {
      // Logic to refresh shares list or show a success message
      console.log('Share bought successfully');
    },
    handleContributionMade() {
      // Handle post-contribution made logic here
      console.log('Contribution made successfully');

    },
    getUserIdFromLocalStorage() {
      // Replace this with actual logic to get the user ID from localStorage
      return localStorage.getItem('user_id');
    }
  }
};
</script>

<style scoped>
/* Add any additional scoped styles here */
</style>