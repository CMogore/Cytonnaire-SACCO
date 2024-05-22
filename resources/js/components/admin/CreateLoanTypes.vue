<template>
    <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-8 rounded-lg max-w-md">
        <h2 class="text-2xl font-semibold mb-4">{{ userData ? 'Edit User' : 'Create New User' }}</h2>
        <form @submit.prevent="userData ? updateLoanType() : addLoanType()">
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
            <input v-model="formData.name" type="text" id="name" name="name" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="mb-4">
            <label for="interest_rate" class="block text-sm font-medium text-gray-700">Interest rate:</label>
            <input v-model="formData.interest_rate" type="number" step="0.01" min="0" max="255" id="interest_rate" name="interest_rate" class="mt-1 p-2 border rounded-md w-full" required>
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
          interest_rate: '',

          
        }
      };
    },
    watch: {
      userData(newVal) {
        // Update form data when userData changes
        if (newVal) {
          this.formData.name = newVal.name;
          this.formData.interest_rate = newVal.interest_rate;

          
        }
      }
    },
    methods: {
      openModal() {
        this.isOpen = true;
        if (this.userData) {
          // Initialize form data if editing existing user
          this.formData.name = this.userData.name;
          this.formData.interest_rate = this.userData.interest_rate;

          
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
    addLoanType() {
      const authToken = localStorage.getItem('auth_token');
      axios.post('/api/admin/createloantype', this.formData, {
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
    updateLoanType() {
      const authToken = localStorage.getItem('auth_token');
      axios.put(`/api/admin/loantype/${this.userData.id}`, this.formData, {
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

  