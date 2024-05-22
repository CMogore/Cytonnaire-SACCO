<template>
    <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-8 rounded-lg max-w-md">
        <h2 class="text-2xl font-semibold mb-4">{{ userData ? 'Edit User' : 'Create New User' }}</h2>
        <form @submit.prevent="userData ? updateUser() : addUser()">
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
            <input v-model="formData.name" type="text" id="name" name="name" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
            <input v-model="formData.email" type="email" id="email" name="email" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
            <input v-model="formData.username" type="text" id="username" name="username" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
            <input v-model="formData.role" type="text" id="role" name="role" class="mt-1 p-2 border rounded-md w-full" required>
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
  export default {
    props: {
      userData: Object // Pass selected user data for editing
    },
    data() {
      return {
        isOpen: false,
        formData: {
          name: '',
          email: '',
          username: '',
          role: ''
        }
      };
    },
    watch: {
      userData(newVal) {
        // Update form data when userData changes
        if (newVal) {
          this.formData.name = newVal.name;
          this.formData.email = newVal.email;
          this.formData.username = newVal.username;
          this.formData.role = newVal.role;
        }
      }
    },
    methods: {
      openModal() {
        this.isOpen = true;
        if (this.userData) {
          // Initialize form data if editing existing user
          this.formData.name = this.userData.name;
          this.formData.email = this.userData.email;
          this.formData.username = this.userData.username;
          this.formData.role = this.userData.role;
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
        this.formData.name = '';
        this.formData.email = '';
        this.formData.username = '';
        this.formData.role = '';
      },
      addUser() {
          // Implement add actor relationship functionality (e.g., send data to backend)
          console.log('Adding new Admin:', this.formData);
        this.closeModal();
        },
        updateUser() {
          // Implement update movie-actor relationship functionality (e.g., send updated data to backend)
          console.log('Updated User Data:', this.formData);
          this.closeModal();
        },
      
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>