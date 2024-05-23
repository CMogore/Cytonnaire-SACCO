<template>
    <div>
       <!-- Create User button -->
       <div class="mt-4 text-right mb-4">
        <button @click="openCreateUserModal" class="px-4 py-2 bg-blue-500 text-white rounded-md">Create User</button>
      </div>
      <!-- Table to display users -->
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">First Name</th>
            <th class="px-4 py-2">Last Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Number</th>
            <th class="px-4 py-2">Role ID</th>
            <th class="px-4 py-2">Employee Status ID</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <!-- Display users data -->
          <tr v-for="user in users" :key="user.id">
            <td class="border px-4 py-2">{{ user.id }}</td>
            <td class="border px-4 py-2">{{ user.firstname }}</td>
            <td class="border px-4 py-2">{{ user.lastname }}</td>
            <td class="border px-4 py-2">{{ user.email }}</td>
            <td class="border px-4 py-2">{{ user.number }}</td>
            <td class="border px-4 py-2">{{ user.role_id }}</td>
            <td class="border px-4 py-2">{{ user.employee_status_id }}</td>
            <td class="border px-4 py-2">
              <button @click="editUser(user)" class="text-blue-500 hover:text-blue-700 focus:outline-none mr-2">Edit</button>
              <button @click="deleteUser(user.id)" class="text-red-500 hover:text-red-700 focus:outline-none">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
  
     
  
      <!-- User creation/edit modal -->
      <UserModal ref="userModal" @saveUser="fetchUsers" :userData="selectedUser" />
    </div>
  </template>
  
  <script>
  import UserModal from '@/components/admin/CreateUsers.vue';
  import axios from 'axios';
  
  export default {
    components: {
      UserModal
    },
    data() {
      return {
        users: [],
        selectedUser: null
      };
    },
    created() {
      this.fetchUsers();
    },
    methods: {
      fetchUsers() {
        const authToken = localStorage.getItem('auth_token');
        axios.get('/api/admin/users', {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.users = response.data;
        })
        .catch(error => {
          console.error('Error fetching users:', error);
        });
      },
      editUser(user) {
        this.selectedUser = { ...user }; // Clone user object for editing
        this.$refs.userModal.openModal();
      },
      deleteUser(userId) {
        const authToken = localStorage.getItem('auth_token');
        axios.delete(`/api/admin/users/${userId}`, {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.fetchUsers();
        })
        .catch(error => {
          console.error('Error deleting user:', error);
        });
      },
      openCreateUserModal() {
        this.selectedUser = null; // Reset selected user for add operation
        this.$refs.userModal.openModal();
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>
  