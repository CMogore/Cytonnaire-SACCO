<template>
    <div>
      <!-- Table to display users -->
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Username</th>
            <th class="px-4 py-2">Role</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Display users data -->
          <tr v-for="user in users" :key="user.id">
            <td class="border px-4 py-2">{{ user.id }}</td>
            <td class="border px-4 py-2">{{ user.name }}</td>
            <td class="border px-4 py-2">{{ user.email }}</td>
            <td class="border px-4 py-2">{{ user.username }}</td>
            <td class="border px-4 py-2">{{ user.role }}</td>
            <td class="border border-gray-300 px-4 py-2">
              <button @click="editUser(user)" class="text-blue-500 hover:text-blue-700 focus:outline-none mr-2">Edit</button>
              <button @click="deleteUser(user.id)" class="text-red-500 hover:text-red-700 focus:outline-none">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Create User button -->
      <div class="mt-4 text-left">
        <button @click="openCreateUserModal" class="px-4 py-2 bg-blue-500 text-white rounded-md">Create User</button>
      </div>
  
      <!-- User creation/edit modal -->
      <UserModal ref="userModal" @closeModal="closeCreateUserModal" :userData="selectedUser" />
    </div>
  </template>
  
  <script>
  import UserModal from '@/components/admin/CreateUsers.vue';
  
  export default {
    components: {
      UserModal
    },
    data() {
      return {
        users: [
          { id: 1, name: 'John Doe', email: 'john@example.com', username: 'john', role: 'Admin' },
          { id: 2, name: 'Jane Smith', email: 'jane@example.com', username: 'jane', role: 'User' },
          // Add more user data
        ],
        selectedUser: null
      };
    },
    methods: {
      editUser(user) {
        this.selectedUser = { ...user }; // Clone user object for editing
        this.$refs.userModal.openModal();
      },
      deleteUser(userId) {
        const index = this.users.findIndex(user => user.id === userId);
        if (index !== -1) {
          this.users.splice(index, 1);
          console.log('Delete User ID:', userId);
        }
        
      },
      openCreateUserModal() {
        if (this.$refs.userModal) {
          this.selectedUser = null; // Reset selected user for add operation
          this.$refs.userModal.openModal();
        }
      },
      closeCreateUserModal() {
        if (this.$refs.userModal) {
          this.$refs.userModal.closeModal();
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>