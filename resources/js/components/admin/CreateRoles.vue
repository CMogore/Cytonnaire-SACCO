<template>
    <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-8 rounded-lg max-w-md">
        <h2 class="text-2xl font-semibold mb-4">{{ userData ? 'Edit User' : 'Create New User' }}</h2>
        <form @submit.prevent="userData ? updateRole() : addRole()">
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
            <input v-model="formData.name" type="text" id="name" name="name" class="mt-1 p-2 border rounded-md w-full" required>
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
          name: '',
          
        }
      };
    },
    watch: {
      userData(newVal) {
        // Update form data when userData changes
        if (newVal) {
          this.formData.name = newVal.name;
          
        }
      }
    },
    methods: {
      openModal() {
        this.isOpen = true;
        if (this.userData) {
          // Initialize form data if editing existing user
          this.formData.name = this.userData.name;
          
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
       
    },
    addRole() {
      const authToken = localStorage.getItem('auth_token');
      axios.post('/api/admin/createrole', this.formData, {
        headers: { 'Authorization': `Bearer ${authToken}` }
      })
      .then(response => {
        this.$emit('saveUser'); // Emit event to refresh user list
        this.closeModal();
      })
      .catch(error => {
        console.error('Error adding status:', error);
      });
    },
    updateRole() {
      const authToken = localStorage.getItem('auth_token');
      axios.put(`/api/admin/role/${this.userData.id}`, this.formData, {
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

  