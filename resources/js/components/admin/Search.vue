<!-- SearchComponent.vue -->
<template>
    <div class="mb-4">
      <input 
        v-model="searchTerm" 
        @input="onSearch" 
        type="text" 
        placeholder="Search by ID or Email" 
        class="w-full p-2 border rounded-md" 
      />
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        searchTerm: '',
      };
    },
    methods: {
      onSearch() {
        this.$emit('search', this.searchTerm);
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any specific styles for the search component if needed */
  </style>
  