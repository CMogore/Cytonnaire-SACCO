<template>
    <div class="relative" @click="toggleNotifications">
      <button class="relative">
        <ion-icon name="notifications" class="text-2xl mt-2"></ion-icon>
        <span v-if="unreadCount > 0" class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
      </button>
      <div v-if="showNotifications" class="absolute right-0 mt-2 w-64 bg-white text-black rounded-lg shadow-lg overflow-hidden">
        <div class="p-4">
          <h4 class="font-bold flex justify-between">
            Notifications
            <button @click.stop="markAllAsRead" class="text-sm text-blue-500">Mark all as read</button>
          </h4>
          <ul>
            <li v-for="notification in notifications" :key="notification.date" class="py-2 border-b border-gray-200">
              {{ notification.message }}
              <span class="text-xs text-gray-500">{{ notification.date }}</span>
            </li>
          </ul>
          <p v-if="notifications.length === 0" class="py-2 text-center text-gray-500">No notifications</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        showNotifications: false,
        notifications: [],
        unreadCount: 0,
      };
    },
    created() {
      this.fetchNotifications();
    },
    methods: {
      toggleNotifications() {
        this.showNotifications = !this.showNotifications;
      },
      async fetchNotifications() {
        try {
          const authToken = localStorage.getItem('auth_token');
          const response = await axios.get('/api/user/notifications', {
            headers: { Authorization: `Bearer ${authToken}` },
          });
          this.notifications = response.data.notifications;
          this.unreadCount = response.data.unread_count;
        } catch (error) {
          console.error('Error fetching notifications:', error);
        }
      },
      async markAllAsRead() {
        try {
          const authToken = localStorage.getItem('auth_token');
          await axios.post('/api/user/notifications/mark-all-read', {}, {
            headers: { Authorization: `Bearer ${authToken}` },
          });
          this.notifications = [];
          this.unreadCount = 0;
          this.showNotifications = false;
        } catch (error) {
          console.error('Error marking all as read:', error);
        }
      }
    },
  };
  </script>
  
  <style scoped>
  /* Add your styles here */
  </style>
  