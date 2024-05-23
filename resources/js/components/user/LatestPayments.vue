<template>
    <div>
      <h2 class="text-2xl font-semibold mb-4 text-emerald-900">Latest Payments</h2>
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="py-2">Loan ID</th>
            <th class="py-2">Amount</th>
            <th class="py-2">Payment Date</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="payment in payments" :key="payment.id">
            <td class="border px-4 py-2">{{ payment.loan_id }}</td>
            <td class="border px-4 py-2">{{ payment.amount }}</td>
            <td class="border px-4 py-2">{{ payment.payment_date }}</td>
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
    created() {
      this.fetchPayments();
    },
    methods: {
      async fetchPayments() {
        const authToken = localStorage.getItem('auth_token');
        try {
          const response = await axios.get('/api/user/latestpayments', {
            headers: {
              Authorization: `Bearer ${authToken}`
            }
          });
          this.payments = response.data;
        } catch (error) {
          console.error('Error fetching payments:', error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your scoped styles here */
  </style>
  