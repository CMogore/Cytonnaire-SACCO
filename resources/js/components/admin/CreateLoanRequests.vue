<template>
    <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-8 rounded-lg max-w-md">
        <h2 class="text-2xl font-semibold mb-4">Reason for Rejection</h2>
        <form @submit.prevent="submitRejection">
          <div class="mb-4">
            <label for="comment" class="block text-sm font-medium text-gray-700">Comment:</label>
            <textarea v-model="formData.comment" id="comment" name="comment" class="mt-1 p-2 border rounded-md w-full" required></textarea>
          </div>
          <div class="flex justify-end">
            <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
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
          comment: ''
        }
      };
    },
    methods: {
      openModal() {
        this.isOpen = true;
      },
      closeModal() {
        this.isOpen = false;
        this.resetForm();
      },
      resetForm() {
        this.formData.comment = '';
      },
      submitRejection() {
        const authToken = localStorage.getItem('auth_token');
        axios.post(`/api/admin/loanrequests/${this.userData.id}/reject`, this.formData, {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.$emit('saveUser'); // Emit event to refresh user list
          this.closeModal();
        })
        .catch(error => {
          console.error('Error rejecting loan request:', error);
        });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>
  