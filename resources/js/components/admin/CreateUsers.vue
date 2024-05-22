<template>
    <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-8 rounded-lg max-w-md">
        <h2 class="text-2xl font-semibold mb-4">{{ userData ? 'Edit User' : 'Create New User' }}</h2>
        <form @submit.prevent="userData ? updateUser() : addUser()">
          <div class="mb-4">
            <label for="firstname" class="block text-sm font-medium text-gray-700">First Name:</label>
            <input v-model="formData.firstname" type="text" id="firstname" name="firstname" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="mb-4">
            <label for="lastname" class="block text-sm font-medium text-gray-700">Last Name:</label>
            <input v-model="formData.lastname" type="text" id="lastname" name="lastname" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
            <input v-model="formData.email" type="email" id="email" name="email" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="mb-4">
            <label for="number" class="block text-sm font-medium text-gray-700">Number:</label>
            <input v-model="formData.number" type="text" id="number" name="number" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="mb-4" v-if="!userData">
            <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
            <input v-model="formData.password" type="password" id="password" name="password" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="mb-4">
            <label for="role_id" class="block text-sm font-medium text-gray-700">Role ID:</label>
            <input v-model="formData.role_id" type="number" id="role_id" name="role_id" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="mb-4">
            <label for="employee_status_id" class="block text-sm font-medium text-gray-700">Employee Status ID:</label>
            <input v-model="formData.employee_status_id" type="number" id="employee_status_id" name="employee_status_id" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="flex justify-end">
            <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">{{ userData ? 'Save' : 'Create' }}</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: {
      userData: Object // Pass selected user data for editing
    },
    data() {
      return {
        isOpen: false,
        formData: {
          firstname: '',
          lastname: '',
          email: '',
          number: '',
          password: '',
          role_id: '',
          employee_status_id: ''
        }
      };
    },
    watch: {
      userData(newVal) {
        // Update form data when userData changes
        if (newVal) {
          this.formData.firstname = newVal.firstname;
          this.formData.lastname = newVal.lastname;
          this.formData.email = newVal.email;
          this.formData.number = newVal.number;
          this.formData.role_id = newVal.role_id;
          this.formData.employee_status_id = newVal.employee_status_id;
          this.formData.password = ''; // Reset password field
        }
      }
    },
    methods: {
      openModal() {
        this.isOpen = true;
        if (this.userData) {
          // Initialize form data if editing existing user
          this.formData.firstname = this.userData.firstname;
          this.formData.lastname = this.userData.lastname;
          this.formData.email = this.userData.email;
          this.formData.number = this.userData.number;
          this.formData.role_id = this.userData.role_id;
          this.formData.employee_status_id = this.userData.employee_status_id;
          this.formData.password = ''; // Reset password field
          this.resetForm();

        } else {
          // Reset form data if adding new user
          this.resetForm();
        }
      },
      closeModal() {
        this.isOpen = false;
        this.resetForm();
      },
      resetForm() {
        this.formData.firstname = '';
        this.formData.lastname = '';
        this.formData.email = '';
        this.formData.number = '';
        this.formData.password = '';
        this.formData.role_id = '';
      this.formData.employee_status_id = '';
    },
    addUser() {
      const authToken = localStorage.getItem('auth_token');
      axios.post('/api/admin/create', this.formData, {
        headers: { 'Authorization': `Bearer ${authToken}` }
      })
      .then(response => {
        this.$emit('saveUser'); // Emit event to refresh user list
        this.closeModal();
      })
      .catch(error => {
        console.error('Error adding user:', error);
      });
    },
    updateUser() {
      const authToken = localStorage.getItem('auth_token');
      axios.put(`/api/admin/users/${this.userData.id}`, this.formData, {
        headers: { 'Authorization': `Bearer ${authToken}` }
      })
      .then(response => {
        this.$emit('saveUser'); // Emit event to refresh user list
        this.closeModal();
      })
      .catch(error => {
        console.error('Error updating user:', error);
      });
    }
  }
};
</script>

<style scoped>
/* Add scoped styles if needed */
</style>

  