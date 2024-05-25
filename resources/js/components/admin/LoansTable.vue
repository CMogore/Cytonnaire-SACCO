<template>
    <div>
      <!-- Table to display users -->
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">User Id</th>
            <th class="px-4 py-2">amount</th>
            <th class="px-4 py-2">Payable amount</th>
            <th class="px-4 py-2">Payment period</th>
            <th class="px-4 py-2">Payment per month</th>



            <th class="px-4 py-2">Loan Type</th>
            <th class="px-4 py-2">Status ID</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <!-- Display users data -->
          <tr v-for="user in loans" :key="user.id">
            <td class="border px-4 py-2">{{ user.id }}</td>
            <td class="border px-4 py-2">{{ user.user_id }}</td>
            <td class="border px-4 py-2">{{ user.amount }}</td>
            <td class="border px-4 py-2">{{ user.payable_amount }}</td>
            <td class="border px-4 py-2">{{ user.payment_period }}</td>
            <td class="border px-4 py-2">{{ user.payment_per_month }}</td>

            <td class="border px-4 py-2">{{ user.type_id }}</td>
            <td class="border px-4 py-2">{{ user.status_id }}</td>
           
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
        loans: [],
      };
    },
    created() {
      this.fetchContributions();
    },
    methods: {
      fetchContributions() {
        const authToken = localStorage.getItem('auth_token');
        axios.get('/api/admin/loans', {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.loans = response.data;
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
  