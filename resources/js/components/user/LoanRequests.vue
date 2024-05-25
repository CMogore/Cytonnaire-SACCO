<template>
    <div>
      <h2 class="text-lg font-semibold mb-4">Loan Requests</h2>
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b border-gray-200">Request ID</th>
            <th class="py-2 px-4 border-b border-gray-200">Amount</th>
            <th class="py-2 px-4 border-b border-gray-200">Payable Amount</th>
            <th class="py-2 px-4 border-b border-gray-200">Payment Period</th>
            <th class="py-2 px-4 border-b border-gray-200">Payment Per Month</th>
            <th class="py-2 px-4 border-b border-gray-200">Type ID</th>
            <th class="py-2 px-4 border-b border-gray-200">Status</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="request in loanRequests" :key="request.id">
            <td class="py-2 px-4 border-b border-gray-200">{{ request.id }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ request.amount }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ request.payable_amount }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ request.payment_period }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ request.payment_per_month }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ request.type.name }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ request.status.name }}</td>
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
        loanRequests: []
      };
    },
    mounted() {
      this.fetchLoanRequests();
    },
    methods: {
      async fetchLoanRequests() {
        try {
          const authToken = localStorage.getItem('auth_token');
          const response = await axios.get('/api/user/loan-requests', {
            headers: { 'Authorization': `Bearer ${authToken}` }
          });
          this.loanRequests = response.data;
        } catch (error) {
          console.error('Error fetching loan requests:', error.response.data);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your styles here */
  </style>
  