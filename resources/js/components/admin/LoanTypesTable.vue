<template>
  <!-- Create User button -->
  <div class="mt-4 text-right mb-2">
        <button @click="openCreateLoanTypeModal" class="px-4 py-2 bg-blue-500 text-white rounded-md">Create Loan Type</button>
      </div>
    <div>
      <!-- Table to display users -->
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Interest Rate</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <!-- Display users data -->
          <tr v-for="user in loantypes" :key="user.id">
            <td class="border px-4 py-2">{{ user.id }}</td>
            <td class="border px-4 py-2">{{ user.name }}</td>
            <td class="border px-4 py-2">{{ user.interest_rate }}</td>
            <td class="border px-4 py-2">
              <button @click="editLoanType(user)" class="text-blue-500 hover:text-blue-700 focus:outline-none mr-2">Edit</button>
              <button @click="deleteLoanType(user.id)" class="text-red-500 hover:text-red-700 focus:outline-none">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
  
      
  
      <!-- User creation/edit modal -->
      <LoanTypesModal ref="userModal" @saveUser="fetchLoanType" :userData="selectedUser" />
    </div>
  </template>
  
  <script>
  import LoanTypesModal from './CreateLoanTypes.vue';
  import axios from 'axios';
  
  export default {
    components: {
      LoanTypesModal
    },
    data() {
      return {
        loantypes: [],
        selectedUser: null
      };
    },
    created() {
      this.fetchLoanType();
    },
    methods: {
      fetchLoanType() {
        const authToken = localStorage.getItem('auth_token');
        axios.get('/api/admin/loantypes', {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.loantypes = response.data;
        })
        .catch(error => {
          console.error('Error fetching loantypes:', error);
        });
      },
      editLoanType(user) {
        this.selectedUser = { ...user }; // Clone user object for editing
        this.$refs.userModal.openModal();
      },
      deleteLoanType(userId) {
        const authToken = localStorage.getItem('auth_token');
        axios.delete(`/api/admin/deleteloantype/${userId}`, {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.fetchLoanType();
        })
        .catch(error => {
          console.error('Error deleting role:', error);
        });
      },
      openCreateLoanTypeModal() {
        this.selectedUser = null; // Reset selected user for add operation
        this.$refs.userModal.openModal();
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>
  