<template>
    <div class="fixed inset-0 overflow-y-auto" :class="{ 'hidden': !isOpen }">
      <div class="flex items-center justify-center min-h-screen">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="relative z-10 bg-white rounded-lg overflow-hidden shadow-xl max-w-md p-6">
          <h2 class="text-lg font-semibold mb-4">Loan Payments</h2>
          <form @submit.prevent="makePayment">
            <div class="mb-4">
              <label for="loanId" class="block text-sm font-medium text-gray-700">Select Loan:</label>
              <select v-model="selectedLoan" id="loanId" name="loanId" class="mt-1 p-2 border rounded-md w-full" required>
                <option value="" disabled>Select Loan</option>
                <option v-for="loan in userLoans" :key="loan.id" :value="loan.id">{{ loan.id }} : for {{ loan.payable_amount }}kshs</option>
              </select>
            </div>
            <div class="mb-4">
              <label for="amount" class="block text-sm font-medium text-gray-700">Payment Amount:</label>
              <input v-model="paymentAmount" type="number" id="amount" name="amount" class="mt-1 p-2 border rounded-md w-full" required>
            </div>
            <div class="flex justify-end">
              <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2">Cancel</button>
              <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Make Payment</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: {
      isOpen: Boolean
    },
    data() {
      return {
        selectedLoan: null,
        paymentAmount: '',
        userLoans: [] // Fetch this from the API
      };
    },
    mounted() {
      // Fetch the user's loans from the API
      this.fetchUserLoans();
    },
    methods: {
      closeModal() {
        this.$emit('close');
        this.resetForm();
      },
      resetForm() {
        this.selectedLoan = null;
        this.paymentAmount = '';
      },
      async fetchUserLoans() {
        try {
          const authToken = localStorage.getItem('auth_token');
          const response = await axios.get('/api/user/loans', {
            headers: { 'Authorization': `Bearer ${authToken}` }
          });
          this.userLoans = response.data;
        } catch (error) {
          console.error('Error fetching user loans:', error.response.data);
        }
      },
      async makePayment() {
        const selectedLoan = this.userLoans.find(loan => loan.id === this.selectedLoan);
        if (!selectedLoan) {
          console.error('Invalid loan selected.');
          return;
        }
  
        if (this.paymentAmount > selectedLoan.payable_amount) {
          alert('Warning: Payment amount exceeds payable amount.');
          return;
        }
  
        const updatedPayableAmount = selectedLoan.payable_amount - this.paymentAmount;
        const statusId = updatedPayableAmount === 0 ? 6 : selectedLoan.status_id;
  
        try {
          const authToken = localStorage.getItem('auth_token');
          const response = await axios.post('/api/user/loan-payments', {
            loan_id: selectedLoan.id,
            amount: this.paymentAmount,
            payment_date: new Date().toISOString()
          }, {
            headers: { 'Authorization': `Bearer ${authToken}` }
          });
  
          // Update the payable amount and status locally
          selectedLoan.payable_amount = updatedPayableAmount;
          selectedLoan.status_id = statusId;
  
          console.log('Payment made:', response.data);
          this.closeModal();
        } catch (error) {
          console.error('Error making payment:', error.response.data);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your modal styling here */
  </style>
  