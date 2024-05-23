<template>
    <div>
      <!-- Table to display users -->
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">User Id</th>
            <th class="px-4 py-2">amount</th>
            <th class="px-4 py-2">Contribution Date</th>
            <th class="px-4 py-2">Status ID</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <!-- Display users data -->
          <tr v-for="user in contributions" :key="user.id">
            <td class="border px-2 py-2 ">{{ user.id }}</td>
            <td class="border px-2 py-2">{{ user.user_id }}</td>
            <td class="border px-2 py-2">{{ user.amount }}</td>
            <td class="border px-2 py-2">{{ user.contribution_date }}</td>
            <td class="border px-2 py-2">{{ user.status_id }}</td>
            <!-- <td class="border px-4 py-2">
              <button @click="editUser(user)" class="text-blue-500 hover:text-blue-700 focus:outline-none mr-2">Edit</button>
              <button @click="deleteUser(user.id)" class="text-red-500 hover:text-red-700 focus:outline-none">Delete</button>
            </td> -->
          </tr>
        </tbody>
      </table>
  
      <!-- Create User button -->
      <!-- <div class="mt-4 text-left">
        <button @click="openCreateUserModal" class="px-4 py-2 bg-blue-500 text-white rounded-md">Create User</button>
      </div> -->
  
      <!-- User creation/edit modal -->
      <!-- <UserModal ref="userModal" @saveUser="fetchUsers" :userData="selectedUser" /> -->
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    
    data() {
      return {
        contributions: [],
        // selectedUser: null
      };
    },
    created() {
      this.fetchContributions();
    },
    methods: {
      fetchContributions() {
        const authToken = localStorage.getItem('auth_token');
        axios.get('/api/admin/contributions', {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.contributions = response.data;
        })
        .catch(error => {
          console.error('Error fetching users:', error);
        });
      },
    //   editUser(user) {
    //     this.selectedUser = { ...user }; // Clone user object for editing
    //     this.$refs.userModal.openModal();
    //   },
    //   deleteUser(userId) {
    //     const authToken = localStorage.getItem('auth_token');
    //     axios.delete(`/api/admin/users/${userId}`, {
    //       headers: { 'Authorization': `Bearer ${authToken}` }
    //     })
    //     .then(response => {
    //       this.fetchUsers();
    //     })
    //     .catch(error => {
    //       console.error('Error deleting user:', error);
    //     });
    //   },
    //   openCreateUserModal() {
    //     this.selectedUser = null; // Reset selected user for add operation
    //     this.$refs.userModal.openModal();
    //   }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>
  