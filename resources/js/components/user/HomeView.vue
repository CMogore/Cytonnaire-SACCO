<template>
  <div>
    <!-- Display total shares and total savings -->
    <div class="grid grid-cols-2 gap-4 mb-8">
      <div class="p-4 bg-white text-black rounded-lg shadow-md">
        <h3 class="text-lg font-semibold">Total Shares</h3>
        <p class="text-2xl">{{ totalShares }}</p>
      </div>
      <div class="p-4 bg-white text-black rounded-lg shadow-md">
        <h3 class="text-lg font-semibold">Total Savings</h3>
        <p class="text-2xl">{{ totalSavings }}</p>
      </div>
    </div>

    <!-- Existing Boxes -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-2 ml-16 px-12">
      <div @click="openModal">
        <div class="bg-gradient-to-r from-orange-100 to-orange-500 rounded-lg p-12 mb-2 h-10 w-10 flex items-center justify-center">
          <div class="text-center">
            <h2 class="text-2xl font-bold mb-2 text-white">BS</h2>
          </div>
        </div>
        <h2 class="text-l font-semibold mb-2 ml-2">Buy Shares</h2>
      </div>
      <div @click="openMCModal">
        <div class="bg-gradient-to-r from-teal-100 to-teal-500 rounded-lg p-12 mb-2 h-10 w-10 flex items-center justify-center">
          <div class="text-center">
            <h2 class="text-2xl font-bold mb-2 text-white">MC</h2>
          </div>
        </div>
        <h2 class="text-l font-semibold mb-2 -ml-6">Make Contributions</h2>
      </div>
      <div @click="openLRModal">
        <div class="bg-gradient-to-r from-pink-100 to-pink-500 rounded-lg p-12 mb-2 h-10 w-10 flex items-center justify-center">
          <div class="text-center">
            <h2 class="text-2xl font-bold mb-2 text-white">LR</h2>
          </div>
        </div>
        <h2 class="text-l font-semibold mb-2 -ml-2">Loan Requests</h2>
      </div>
      <div @click="openLPModal">
        <div class="bg-gradient-to-r from-fuchsia-100 to-fuchsia-500 rounded-lg p-12 mb-2 h-10 w-10 flex items-center justify-center">
          <div class="text-center">
            <h2 class="text-2xl font-bold mb-2 text-white">LP</h2>
          </div>
        </div>
        <h2 class="text-l font-semibold mb-2 -ml-2">Loan Payments</h2>
      </div>
      <div @click="openSTModal">
        <div class="bg-gradient-to-r from-green-100 to-green-500 rounded-lg p-12 ml-2 mb-2 h-10 w-10 flex items-center justify-center">
          <div class="text-center">
            <h2 class="text-2xl font-bold mb-2 text-white">ST</h2>
          </div>
        </div>
        <h2 class="text-l font-semibold mb-2">Transfer Shares</h2>
      </div>
    </div>

    <BuySharesModal :isOpen="isModalOpen" :userId="userId" @close="closeModal" @shareBought="handleShareBought" />
    <MakeContributionsModal :isOpen="isMakeContributionsModalOpen" @close="isMakeContributionsModalOpen = false" @contributionMade="handleContributionMade" />
    <ShareTransferModal :isOpen="isShareTransfersModalOpen" @close="isShareTransfersModalOpen = false" @sharesTransferred="handleSharesTransferred" />
    <LoanRequestModal :isOpen="isLoanRequestModalOpen" @close="isLoanRequestModalOpen = false" :loanTypes="loanTypes" @loanRequestSubmitted="handleLoanRequestSubmitted" />
    <LoanPaymentsModal :isOpen="isLoanPaymentsModalOpen" @close="isLoanPaymentsModalOpen = false" />

    <div class="flex h-[24rem] mt-8 rounded shadow-emerald-900 shadow-2xl">
      <!-- Side panel -->
      <HomePanel @menuItemSelected="handleMenuItemSelected" />

      <!-- Main content area -->
      <div class="flex-1 p-6 bg-gray-100">
        <div v-if="selectedMenuItem === 'contributions'">
          <latest-contributions />
        </div>
        <div v-else-if="selectedMenuItem === 'loans'">
          <active-loans />
        </div>
        <div v-else-if="selectedMenuItem === 'latestpayments'">
          <latest-payments />
        </div>
        <!-- Add more sections for other menu items -->
      </div>
    </div>
  </div>
</template>

<script>
import HomePanel from './HomePanel.vue';
import BuySharesModal from './BuyShares.vue';
import MakeContributionsModal from './MakeContribution.vue';
import ShareTransferModal from './ShareTransfer.vue';
import LatestContributions from './LatestContributions.vue';
import ActiveLoans from './ActiveLoans.vue';
import LatestPayments from './LatestPayments.vue';
import LoanRequestModal from './MakeLoanRequest.vue';
import LoanPaymentsModal from './MakeLoanPayment.vue';
import axios from 'axios';

export default {
  components: {
    HomePanel,
    BuySharesModal,
    MakeContributionsModal,
    ShareTransferModal,
    LatestContributions,
    ActiveLoans,
    LatestPayments,
    LoanRequestModal,
    LoanPaymentsModal
  },
  data() {
    return {
      selectedMenuItem: 'home',
      isMakeContributionsModalOpen: false,
      isModalOpen: false,
      isShareTransfersModalOpen: false,
      isLoanRequestModalOpen: false,
      isLoanPaymentsModalOpen: false,
      userId: null, // Replace with actual user ID retrieval logic
      totalShares: 0,
      totalSavings: 0
    };
  },
  created() {
    this.userId = this.getUserIdFromLocalStorage(); // Retrieve user ID from localStorage or other source
    this.fetchStats(); // Fetch total shares and total savings
  },
  methods: {
    openLRModal() {
      this.isLoanRequestModalOpen = true;
    },
    openLPModal() {
      this.isLoanPaymentsModalOpen = true;
    },
    handleLoanRequestSubmitted(data) {
      alert('Loan request submitted:', data);
      // Update your UI or perform other actions here
    },
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
    openSTModal() {
      this.isShareTransfersModalOpen = true;
    },
    handleShareBought() {
      // Logic to refresh shares list or show a success message
      alert('Share bought successfully');
    },
    handleContributionMade() {
      // Handle post-contribution made logic here
      alert('Contribution made successfully');
    },
    handleSharesTransferred() {
      // Handle post-shares transferred logic here
      alert('Shares transferred successfully');
    },
    getUserIdFromLocalStorage() {
      // Replace this with actual logic to get the user ID from localStorage
      return localStorage.getItem('user_id');
    },
    async fetchStats() {
      try {
        const authToken = localStorage.getItem('auth_token');
        const response = await axios.get('/api/user/stats', {
          headers: { Authorization: `Bearer ${authToken}` },
        });
        this.totalShares = response.data.totalShares;
        this.totalSavings = response.data.totalSavings;
      } catch (error) {
        console.error('Error fetching stats:', error.response.data);
      }
    }
  }
};
</script>

<style scoped>
/* Add any additional scoped styles here */
</style>
