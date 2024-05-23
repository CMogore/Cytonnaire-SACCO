<template>
    <div>
      <!-- Table to display users -->
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">User Id</th>
            <th class="px-4 py-2">Total Shares</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <!-- Display users data -->
          <tr v-for="user in shares" :key="user.id">
            <td class="border px-4 py-2">{{ user.id }}</td>
            <td class="border px-4 py-2">{{ user.user_id }}</td>
            <td class="border px-4 py-2">{{ user.total_shares }}</td>
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
        shares: [],
      };
    },
    created() {
      this.fetchShares();
    },
    methods: {
      fetchShares() {
        const authToken = localStorage.getItem('auth_token');
        axios.get('/api/admin/shares', {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.shares = response.data;
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
  