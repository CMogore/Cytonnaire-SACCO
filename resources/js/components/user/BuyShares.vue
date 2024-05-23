<template>
    <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-8 rounded-lg max-w-md">
        <h2 class="text-2xl font-semibold mb-4">Buy Shares</h2>
        <form @submit.prevent="buyShares">
          <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount:</label>
            <input v-model="amount" type="number" id="amount" name="amount" class="mt-1 p-2 border rounded-md w-full" required>
          </div>
          <div class="flex justify-end">
            <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: {
      isOpen: Boolean,
      userId: Number
    },
    data() {
      return {
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
      this.amount = '';
    },
      closeModal() {
        this.$emit('close');
      },
      buyShares() {
        const shareData = {
          total_shares: this.amount,
        };
  
        const authToken = localStorage.getItem('auth_token');
  
        axios.post('/api/user/buyshares', shareData, {
          headers: { 'Authorization': `Bearer ${authToken}` }
        })
        .then(response => {
          this.$emit('shareBought'); // Emit event to refresh shares list
          this.closeModal();
        })
        .catch(error => {
          console.error('Error buying shares:', error);
        });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>
  