<template>
    <div>
      <!-- Table to display users -->
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">From User Id</th>
            <th class="px-4 py-2">To User Id</th>
            <th class="px-4 py-2">Amount</th>
            <th class="px-4 py-2">Date</th>

          </tr>
        </thead>
        <tbody>
          <!-- Display users data -->
          <tr v-for="user in sharetransfers" :key="user.id">
            <td class="border px-4 py-2">{{ user.id }}</td>
            <td class="border px-4 py-2">{{ user.from_user_id }}</td>
            <td class="border px-4 py-2">{{ user.to_user_id }}</td>
            <td class="border px-4 py-2">{{ user.amount }}</td>
            <td class="border px-4 py-2">{{ user.date }}</td>

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
        sharetransfers: [],
      };
    },
    created() {
      this.fetchShareTransfers();
    },
    methods: {
      fetchShareTransfers() {
        const authToken = localStorage.getItem('auth_token');
        axios.get('/api/admin/sharetransfers', {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.sharetransfers = response.data;
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
  