<template>
    <div>
      <!-- Table to display users -->
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Display users data -->
          <tr v-for="user in statuses" :key="user.id">
            <td class="border px-4 py-2">{{ user.id }}</td>
            <td class="border px-4 py-2">{{ user.name }}</td>
            <td class="border px-4 py-2">
              <button @click="editStatus(user)" class="text-blue-500 hover:text-blue-700 focus:outline-none mr-2">Edit</button>
              <button @click="deleteStatus(user.id)" class="text-red-500 hover:text-red-700 focus:outline-none">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Create User button -->
      <div class="mt-4 text-left">
        <button @click="openCreateStatusModal" class="px-4 py-2 bg-blue-500 text-white rounded-md">Create Status</button>
      </div>
  
      <!-- User creation/edit modal -->
      <StatusModal ref="userModal" @saveUser="fetchStatus" :userData="selectedUser" />
    </div>
  </template>
  
  <script>
  import StatusModal from './CreateStatuses.vue';
  import axios from 'axios';
  
  export default {
    components: {
      StatusModal
    },
    data() {
      return {
        statuses: [],
        selectedUser: null
      };
    },
    created() {
      this.fetchStatus();
    },
    methods: {
      fetchStatus() {
        const authToken = localStorage.getItem('auth_token');
        axios.get('/api/admin/statuses', {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.statuses = response.data;
        })
        .catch(error => {
          console.error('Error fetching statuses:', error);
        });
      },
      editStatus(user) {
        this.selectedUser = { ...user }; // Clone user object for editing
        this.$refs.userModal.openModal();
      },
      deleteStatus(userId) {
        const authToken = localStorage.getItem('auth_token');
        axios.delete(`/api/admin/deletestatus/${userId}`, {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.fetchStatus();
        })
        .catch(error => {
          console.error('Error deleting user:', error);
        });
      },
      openCreateStatusModal() {
        this.selectedUser = null; // Reset selected user for add operation
        this.$refs.userModal.openModal();
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>
  