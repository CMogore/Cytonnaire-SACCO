<template>
    <div class="fixed inset-0 overflow-y-auto" :class="{ 'hidden': !isOpen }">
      <div class="flex items-center justify-center min-h-screen">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="relative z-10 bg-white rounded-lg overflow-hidden shadow-xl max-w-md p-6">
          <h2 class="text-lg font-semibold mb-4">Make Loan Request</h2>
          <form @submit.prevent="submitLoanRequest">
            <div class="mb-4">
              <label for="amount" class="block text-sm font-medium text-gray-700">Amount:</label>
              <input v-model="formData.amount" type="number" id="amount" name="amount" class="mt-1 p-2 border rounded-md w-full" required @input="calculateAmounts">
            </div>
            <div class="mb-4">
              <label for="paymentPeriod" class="block text-sm font-medium text-gray-700">Payment Period (months):</label>
              <input v-model="formData.paymentPeriod" type="number" id="paymentPeriod" name="paymentPeriod" class="mt-1 p-2 border rounded-md w-full" required @input="calculateAmounts">
            </div>
            <div class="mb-4">
              <label for="loanType" class="block text-sm font-medium text-gray-700">Loan Type:</label>
              <select v-model="formData.typeId" id="loanType" name="loanType" class="mt-1 p-2 border rounded-md w-full" required @input="calculateAmounts">
                <option value="" disabled selected>Select Loan Type</option>
                <option v-for="type in loanTypes" :key="type.id" :value="type.id">{{ type.name }} ({{ type.interest_rate }} interest)</option>
              </select>
            </div>
            <div class="mb-4">
              <label for="paymentPerMonth" class="block text-sm font-medium text-gray-700">Payment Per Month:</label>
              <input v-model="paymentPerMonth" type="number" id="paymentPerMonth" name="paymentPerMonth" class="mt-1 p-2 border rounded-md w-full" readonly>
            </div>
            <div class="mb-4">
              <label for="payableAmount" class="block text-sm font-medium text-gray-700">Payable Amount:</label>
              <input v-model="payableAmount" type="number" id="payableAmount" name="payableAmount" class="mt-1 p-2 border rounded-md w-full" readonly>
            </div>
            <div class="flex justify-end">
              <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2">Cancel</button>
              <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Submit</button>
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
        formData: {
          amount: '',
          paymentPeriod: '',
          typeId: ''
        },
        loanTypes: [],
        paymentPerMonth: '',
        payableAmount: null
      };
    },
    mounted() {
      this.fetchLoanTypes();
    },
    methods: {
      closeModal() {
        this.$emit('close');
        this.resetForm();
      },
      resetForm() {
        this.formData.amount = '';
        this.formData.paymentPeriod = '';
        this.formData.typeId = '';
        this.paymentPerMonth = '';
        this.payableAmount = null;
      },
      async fetchLoanTypes() {
        try {
          const authToken = localStorage.getItem('auth_token');
          const response = await axios.get('/api/user/loan-types', {
            headers: { 'Authorization': `Bearer ${authToken}` }
          });
          this.loanTypes = response.data;
        } catch (error) {
          console.error('Error fetching loan types:', error.response.data);
        }
      },
      calculateAmounts() {
        if (this.formData.amount && this.formData.paymentPeriod && this.formData.typeId) {
          const loanType = this.loanTypes.find(type => type.id === this.formData.typeId);
          const interestRate = loanType.interest_rate ; // Convert interest rate to decimal
          const periodInYears = this.formData.paymentPeriod / 12;
          const interest = this.formData.amount * interestRate * periodInYears;
          this.payableAmount = parseFloat(this.formData.amount) + parseFloat(interest);
  
          // Calculate payment per month
          this.paymentPerMonth = (this.payableAmount / this.formData.paymentPeriod).toFixed(2);
        } else {
          this.paymentPerMonth = '';
          this.payableAmount = null;
        }
      },
      submitLoanRequest() {
        // Submit the loan request
        const authToken = localStorage.getItem('auth_token');
        axios.post('/api/user/loan-requests', {
          user_id: this.userId,
          amount: this.formData.amount,
          payable_amount: this.payableAmount,
          payment_period: this.formData.paymentPeriod,
          payment_per_month: this.paymentPerMonth,
          type_id: this.formData.typeId
        }, {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          console.log('Loan request submitted:', response.data);
          this.closeModal();
        })
        .catch(error => {
          console.error('Error making loan request:', error.response.data);
        });
      }
    },
    watch: {
      'formData.amount': 'calculateAmounts',
      'formData.paymentPeriod': 'calculateAmounts',
      'formData.typeId': 'calculateAmounts'
    }
  };
  </script>
  
  