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
          <tr v-for="user in roles" :key="user.id">
            <td class="border px-4 py-2">{{ user.id }}</td>
            <td class="border px-4 py-2">{{ user.name }}</td>
            <td class="border px-4 py-2">
              <button @click="editRole(user)" class="text-blue-500 hover:text-blue-700 focus:outline-none mr-2">Edit</button>
              <button @click="deleteRole(user.id)" class="text-red-500 hover:text-red-700 focus:outline-none">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Create User button -->
      <div class="mt-4 text-left">
        <button @click="openCreateRoleModal" class="px-4 py-2 bg-blue-500 text-white rounded-md">Create Role</button>
      </div>
  
      <!-- User creation/edit modal -->
      <RoleModal ref="userModal" @saveUser="fetchRole" :userData="selectedUser" />
    </div>
  </template>
  
  <script>
  import RoleModal from './CreateRoles.vue';
  import axios from 'axios';
  
  export default {
    components: {
      RoleModal
    },
    data() {
      return {
        roles: [],
        selectedUser: null
      };
    },
    created() {
      this.fetchRole();
    },
    methods: {
      fetchRole() {
        const authToken = localStorage.getItem('auth_token');
        axios.get('/api/admin/roles', {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.roles = response.data;
        })
        .catch(error => {
          console.error('Error fetching roles:', error);
        });
      },
      editRole(user) {
        this.selectedUser = { ...user }; // Clone user object for editing
        this.$refs.userModal.openModal();
      },
      deleteRole(userId) {
        const authToken = localStorage.getItem('auth_token');
        axios.delete(`/api/admin/deleterole/${userId}`, {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.fetchRole();
        })
        .catch(error => {
          console.error('Error deleting role:', error);
        });
      },
      openCreateRoleModal() {
        this.selectedUser = null; // Reset selected user for add operation
        this.$refs.userModal.openModal();
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>
  