<template>
    <div>
      <h2 class="text-2xl font-semibold mb-4">Latest Contributions</h2>
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="py-2">Amount</th>
            <th class="py-2">Contribution Date</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="contribution in contributions" :key="contribution.id">
            <td class="border px-4 py-2">{{ contribution.amount }}</td>
            <td class="border px-4 py-2">{{ contribution.contribution_date }}</td>
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
        contributions: []
      };
    },
    created() {
      this.fetchContributions();
    },
    methods: {
      async fetchContributions() {
        const authToken = localStorage.getItem('auth_token');
        try {
          const response = await axios.get('/api/user/latestcontributions', {
            headers: {
              Authorization: `Bearer ${authToken}`
            }
          });
          this.contributions = response.data;
        } catch (error) {
          console.error('Error fetching contributions:', error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your scoped styles here */
  </style>
  