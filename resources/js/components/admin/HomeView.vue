<template>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4  ">
      <div class="bg-orange-500 rounded-lg p-4 h-48 flex items-center justify-center">
        <div class="text-center">
          <h2 class="text-2xl font-semibold mb-2">AUM</h2>
          <div class=" rounded-lg p-4 text-3xl">{{ totalShares }}</div>
        </div>
      </div>
      <div class="bg-teal-500 rounded-lg p-4 flex h-48 items-center justify-center">
        <div class="text-center">
          <h2 class="text-2xl font-semibold mb-2">Pending Loan Requests</h2>
          <div class=" rounded-lg p-4 text-3xl">{{ totalLoanRequests }}</div>
        </div>
      </div>
      <div class="bg-pink-500 rounded-lg p-4 h-48 flex items-center justify-center">
        <div class="text-center">
          <h2 class="text-2xl font-semibold mb-2">Total Users</h2>
          <div class=" rounded-lg p-4 text-3xl">{{ totalUsers }}</div>
        </div>
      </div>
      <div class="bg-fuchsia-500 rounded-lg p-4 h-48 flex items-center justify-center">
        <div class="text-center">
          <h2 class="text-2xl font-semibold mb-2">Active Loans</h2>
          <div class=" rounded-lg p-4 text-3xl">{{ totalLoans }}</div>
        </div>
      </div>
      <div class="bg-green-500 rounded-lg p-4 h-48 flex items-center justify-center">
        <div class="text-center">
          <h2 class="text-2xl font-semibold mb-2">Pending Contributions</h2>
          <div class=" rounded-lg p-4 text-3xl">{{ pendingContributions }}</div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        totalShares: 0,
        totalLoanRequests: 0,
        totalLoans: 0,
        totalUsers: 0,
        pendingContributions: 0,
      };
    },
    created() {
      this.fetchDashboardData();
    },
    methods: {
      fetchDashboardData() {
        // Make sure to include the authentication token in the request headers
        const authToken = localStorage.getItem('auth_token');
        const headers = {
          'Authorization': `Bearer ${authToken}`
        };
  
        axios.get('/api/admin/home', { headers })
          .then(response => {
            this.totalShares = response.data.totalShares;
            this.totalLoanRequests = response.data.totalLoanRequests;
            this.totalLoans = response.data.totalLoans;
            this.pendingContributions = response.data.pendingContributions;


            this.totalUsers = response.data.totalUsers;
          })
          .catch(error => {
            console.error('Error fetching dashboard data:', error);
          });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add any additional scoped styles here */
  </style>
  