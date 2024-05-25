<template>
    <div>
      <h2 class="text-lg font-semibold mb-4">Ongoing Loans</h2>
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b border-gray-200">Loan ID</th>
            <th class="py-2 px-4 border-b border-gray-200">Amount</th>
            <th class="py-2 px-4 border-b border-gray-200">Payable Amount</th>
            <th class="py-2 px-4 border-b border-gray-200">Payment Period</th>
            <th class="py-2 px-4 border-b border-gray-200">Payment Per Month</th>
            <th class="py-2 px-4 border-b border-gray-200">Loan Type</th>
            <th class="py-2 px-4 border-b border-gray-200">Status</th>

          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="loan in loans" :key="loan.id">
            <td class="py-2 px-4 border-b border-gray-200">{{ loan.id }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ loan.amount }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ loan.payable_amount }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ loan.payment_period }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ loan.payment_per_month }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ loan.type.name }}</td>
            <td class="py-2 px-4 border-b border-gray-200">{{ loan.status.name }}</td>

            
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
        loans: []
      };
    },
    mounted() {
      this.fetchOngoingLoans();
    },
    methods: {
      async fetchOngoingLoans() {
        try {
          const authToken = localStorage.getItem('auth_token');
          const response = await axios.get('/api/user/loans', {
            headers: { 'Authorization': `Bearer ${authToken}` }
          });
          this.loans = response.data.filter(loan => loan.status_id === 5);
        } catch (error) {
          console.error('Error fetching ongoing loans:', error.response.data);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your styles here */
  </style>
  