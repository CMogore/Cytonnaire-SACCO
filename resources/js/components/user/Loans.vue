<template>
    <div>
      <!-- Tabs Navigation -->
      <div class="flex   justify-center">
        <button 
          :class="tabClass(activeTab === 'ongoingLoans')"
          @click="activeTab = 'ongoingLoans'">
          Ongoing Loans
        </button>
        <button 
          :class="tabClass(activeTab === 'loanRepayments')"
          @click="activeTab = 'loanRepayments'">
          Loan Repayments
        </button>
        <button 
          :class="tabClass(activeTab === 'loanRequests')"
          @click="activeTab = 'loanRequests'">
          Loan Requests
        </button>
      </div>
  
      <!-- Tabs Content -->
      <div class="p-4">
        <OngoingLoans v-if="activeTab === 'ongoingLoans'" />
        <LoanRepayments v-if="activeTab === 'loanRepayments'" />
        <LoanRequests v-if="activeTab === 'loanRequests'" />
      </div>
    </div>
  </template>
  
  <script>
  import OngoingLoans from './OngoingLoans.vue';
  import LoanRepayments from './LoanRepayments.vue';
  import LoanRequests from './LoanRequests.vue';
  
  export default {
    components: {
      OngoingLoans,
      LoanRepayments,
      LoanRequests
    },
    data() {
      return {
        activeTab: 'ongoingLoans'
      };
    },
    methods: {
      tabClass(isActive) {
        return isActive 
          ? 'px-4 py-2 text-white bg-emerald-900 '
          : 'px-4 py-2 text-black font-bold';
      }
    }
  };
  </script>
  
  <style scoped>
  button {
    outline: none;
  }
  </style>
  