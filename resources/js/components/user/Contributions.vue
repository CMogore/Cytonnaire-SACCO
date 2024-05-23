<template>
    <div>
      <div class="flex space-x-2 justify-center mb-4">
        <button @click="viewMode = 'made'" :class="{'bg-emerald-900 text-white': viewMode === 'made'}" class="px-4 py-2">Made Contributions</button>
        <button @click="viewMode = 'pending'" :class="{'bg-emerald-900 text-white': viewMode === 'pending'}" class="px-4 py-2">Pending Contributions</button>
      </div>
  
      <div v-if="viewMode === 'made'">
        <h2 class="text-2xl font-semibold mb-4">Made Contributions</h2>
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="py-2">Amount</th>
              <th class="py-2">Contribution Date</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr v-for="contribution in madeContributions" :key="contribution.id">
              <td class="border px-4 py-2">{{ contribution.amount }}</td>
              <td class="border px-4 py-2">{{ contribution.contribution_date }}</td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <div v-else>
        <h2 class="text-2xl font-semibold mb-4">Pending Contributions</h2>
        <div v-if="pendingContribution > 0" class="text-red-500">
          <p>You have a pending contribution of: {{ pendingContribution }}</p>
        </div>
        <div v-else>
          <p>You have no pending contributions.</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        viewMode: 'made', // 'made' or 'pending'
        madeContributions: [],
        pendingContribution: 0
      };
    },
    created() {
      this.fetchMadeContributions();
      this.fetchPendingContributions();
    },
    methods: {
      async fetchMadeContributions() {
        const authToken = localStorage.getItem('auth_token');
        try {
          const response = await axios.get('/api/user/made-contributions', {
            headers: {
              Authorization: `Bearer ${authToken}`
            }
          });
          this.madeContributions = response.data;
        } catch (error) {
          console.error('Error fetching made contributions:', error);
        }
      },
      async fetchPendingContributions() {
        const authToken = localStorage.getItem('auth_token');
        try {
          const response = await axios.get('/api/user/pending-contributions', {
            headers: {
              Authorization: `Bearer ${authToken}`
            }
          });
          this.pendingContribution = response.data.pending_contribution;
        } catch (error) {
          console.error('Error fetching pending contributions:', error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your scoped styles here */
  </style>
  