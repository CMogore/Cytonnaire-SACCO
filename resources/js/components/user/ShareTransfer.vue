<template>
    <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-8 rounded-lg max-w-md">
        <h2 class="text-2xl font-semibold mb-4">Transfer Shares</h2>
        <form @submit.prevent="transferShares">
          <div class="mb-4">
            <label for="to_user_id" class="block text-sm font-medium text-gray-700">To User ID:</label>
            <input v-model="to_user_id" type="number" id="to_user_id" name="to_user_id" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount:</label>
            <input v-model="amount" type="number" id="amount" name="amount" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="flex justify-end">
            <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Transfer</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: {
      isOpen: Boolean
    },
    data() {
      return {
        to_user_id: '',
        amount: ''
      };
    },
    watch: {
    
    isOpen(newVal) {
      if (!newVal) {
        this.resetForm();
      }
    }
  },
    methods: {
        resetForm() {
      this.to_user_id = '';
      this.amount = '';
    },
      closeModal() {
        this.$emit('close');
      },
      transferShares() {
        const transferData = {
          to_user_id: this.to_user_id,
          amount: this.amount,
        };
  
        const authToken = localStorage.getItem('auth_token');
  
        axios.post('/api/user/sharetransfers', transferData, {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.$emit('sharesTransferred'); // Emit event to refresh shares list
          this.closeModal();
        })
        .catch(error => {
          console.error('Error transferring shares:', error);
        });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add your scoped styles here */
  </style>
  