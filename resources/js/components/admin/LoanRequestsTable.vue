<template>
    <div>
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">User Id</th>
            <th class="px-4 py-2">Amount</th>
            <th class="px-4 py-2">Payable Amount</th>
            <th class="px-4 py-2">Type Id</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="user in loanrequests" :key="user.id">
            <td class="border px-4 py-2">{{ user.id }}</td>
            <td class="border px-4 py-2">{{ user.user_id }}</td>
            <td class="border px-4 py-2">{{ user.amount }}</td>
            <td class="border px-4 py-2">{{ user.payable_amount }}</td>
            <td class="border px-4 py-2">{{ user.type_id }}</td>
            <td class="border px-4 py-2">
              <button @click="acceptRequest(user.id)" class="text-blue-500 hover:text-blue-700 focus:outline-none mr-2">Accept</button>
              <button @click="rejectRequest(user)" class="text-red-500 hover:text-red-700 focus:outline-none">Reject</button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <RejectLoanRequestModal ref="rejectModal" @saveUser="fetchLoanRequests" :userData="selectedUser" />
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import RejectLoanRequestModal from './CreateLoanRequests.vue';

  
  export default {
    components: {
      RejectLoanRequestModal
    },
    data() {
      return {
        loanrequests: [],
        selectedUser: null
      };
    },
    created() {
      this.fetchLoanRequests();
    },
    methods: {
      fetchLoanRequests() {
        const authToken = localStorage.getItem('auth_token');
        axios.get('/api/admin/loanrequests', {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.loanrequests = response.data;
        })
        .catch(error => {
          console.error('Error fetching loan requests:', error);
        });
      },
      acceptRequest(userId) {
        const authToken = localStorage.getItem('auth_token');
        axios.post(`/api/admin/loanrequests/${userId}/accept`, {}, {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.fetchLoanRequests();
        })
        .catch(error => {
          console.error('Error accepting loan request:', error);
        });
      },
      rejectRequest(user) {
        this.selectedUser = { ...user }; // Clone user object for editing
        this.$refs.rejectModal.openModal();
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>
  