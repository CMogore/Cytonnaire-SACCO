<template>
    <div>
      <h2 class="text-2xl font-semibold mb-4 text-emerald-900">Active Loans</h2>
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="py-2">Amount</th>
            <th class="py-2">Payable Amount</th>
            <th class="py-2">Payment Period</th>
            <th class="py-2">Payment Per Month</th>
            <th class="py-2">Type</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="loan in loans" :key="loan.id">
            <td class="border px-4 py-2">{{ loan.amount }}</td>
            <td class="border px-4 py-2">{{ loan.payable_amount }}</td>
            <td class="border px-4 py-2">{{ loan.payment_period }}</td>
            <td class="border px-4 py-2">{{ loan.payment_per_month }}</td>
            <td class="border px-4 py-2">{{ loan.type_id }}</td>
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
    created() {
      this.fetchLoans();
    },
    methods: {
      async fetchLoans() {
        const authToken = localStorage.getItem('auth_token');
        try {
          const response = await axios.get('/api/user/activeloans', {
            headers: {
              Authorization: `Bearer ${authToken}`
            }
          });
          this.loans = response.data;
        } catch (error) {
          console.error('Error fetching loans:', error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your scoped styles here */
  </style>
  