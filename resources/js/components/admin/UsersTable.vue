<template>
  <div class="p-4">
     <!-- Search Component -->
     <SearchComponent @search="searchUsers" />
    <!-- Create User button -->
    <div class="mt-4 text-right mb-4">
      <button @click="openCreateUserModal" class="px-4 py-2 bg-blue-500 text-white rounded-md">Create User</button>
    </div>

   

    <!-- Table to display users -->
    <div class="overflow-x-auto">
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">First Name</th>
            <th class="px-4 py-2">Last Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Number</th>
            <th class="px-4 py-2">Role</th>
            <th class="px-4 py-2">Employee Status</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="user in filteredUsers" :key="user.id">
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
    </div>

    <!-- User creation/edit modal -->
    <UserModal ref="userModal" @saveUser="fetchUsers" :userData="selectedUser" />
  </div>
</template>

<script>
import UserModal from '@/components/admin/CreateUsers.vue';
import SearchComponent from './Search.vue';
import axios from 'axios';

export default {
  components: {
    UserModal,
    SearchComponent
  },
  data() {
    return {
      users: [],
      selectedUser: null,
      searchTerm: ''
    };
  },
  computed: {
    filteredUsers() {
      return this.users.filter(user => {
        return user.id.toString().includes(this.searchTerm) || user.email.includes(this.searchTerm);
      });
    }
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
    },
    searchUsers(searchTerm) {
      this.searchTerm = searchTerm;
    }
  }
};
</script>

<style scoped>
.table-auto {
  width: 100%;
  border-collapse: collapse;
}

.table-auto th, .table-auto td {
  border: 1px solid #ddd;
  padding: 8px;
}

.table-auto th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #f2f2f2;
}

@media (max-width: 640px) {
  .table-auto thead {
    display: none;
  }
  
  .table-auto tr {
    display: block;
    margin-bottom: 10px;
  }
  
  .table-auto td {
    display: block;
    text-align: right;
    padding-left: 50%;
    position: relative;
  }
  
  .table-auto td::before {
    content: attr(data-label);
    position: absolute;
    left: 0;
    width: 50%;
    padding-left: 15px;
    font-weight: bold;
    text-align: left;
  }
}
</style>
