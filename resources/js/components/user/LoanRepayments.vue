<template>
    <div>
      <h2 class="text-lg font-semibold mb-4">Loan Repayments</h2>
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b border-gray-200">Loan ID</th>
            <th class="py-2 px-4 border-b border-gray-200">Amount</th>
            <th class="py-2 px-4 border-b border-gray-200">Payment Date</th>
          </tr>
        </thead>
        <tbody CLASS="text-center">
          <tr v-for="payment in payments" :key="payment.id">
            <td class="py-2 px-4 border-b border-gray-200">{{ payment.loan_id }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ payment.amount }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ payment.payment_date }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        payments: []
      };
    },
    mounted() {
      this.fetchLoanRepayments();
    },
    methods: {
      async fetchLoanRepayments() {
        try {
          const authToken = localStorage.getItem('auth_token');
          const response = await axios.get('/api/user/loan-repayments', {
            headers: { 'Authorization': `Bearer ${authToken}` }
          });
          this.payments = response.data;
        } catch (error) {
          console.error('Error fetching loan repayments:', error.response.data);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your styles here */
  </style>
  