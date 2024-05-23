<template>
    <div>
      <!-- Table to display users -->
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Loan Id</th>
            <th class="px-4 py-2">amount</th>
            <th class="px-4 py-2">Payment Date</th>

          </tr>
        </thead>
        <tbody>
          <!-- Display users data -->
          <tr v-for="user in loanpayments" :key="user.id">
            <td class="border px-4 py-2">{{ user.id }}</td>
            <td class="border px-4 py-2">{{ user.loan_id }}</td>
            <td class="border px-4 py-2">{{ user.amount }}</td>
            <td class="border px-4 py-2">{{ user.payment_date }}</td>
            
           
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
        loanpayments: [],
      };
    },
    created() {
      this.fetchLoanPayments();
    },
    methods: {
      fetchLoanPayments() {
        const authToken = localStorage.getItem('auth_token');
        axios.get('/api/admin/loanpayments', {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.loanpayments = response.data;
        })
        .catch(error => {
          console.error('Error fetching users:', error);
        });
      },
    
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>
  