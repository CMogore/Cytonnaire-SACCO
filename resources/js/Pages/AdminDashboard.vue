<template>
    <div class="flex h-screen">
      <!-- Side panel -->
      <SidePanel @menuItemSelected="handleMenuItemSelected" />
  
      <!-- Main content area -->
      <div class="flex-1 p-6 bg-gray-100">
        <!-- Display different sections based on selected menu item -->
        <div v-if="selectedMenuItem === 'home'">
          <h2 class="text-3xl font-semibold mb-4">DASHBOARD</h2>
          <Home></Home>
        </div>
        <div v-if="selectedMenuItem === 'users'">
          <h2 class="text-2xl font-semibold mb-4">Users Table</h2>
          <UsersTable />
        </div>
        <div v-else-if="selectedMenuItem === 'contributions'">
          <h2 class="text-2xl font-semibold mb-4">Contributions Table</h2>
          <ContributionsTable />
        </div>
        <div v-else-if="selectedMenuItem === 'loanrequests'">
          <h2 class="text-2xl font-semibold mb-4">Loan Requests Table</h2>
          <LoanRequests />
        </div>
        <div v-else-if="selectedMenuItem === 'statuses'">
          <h2 class="text-2xl font-semibold mb-4">Statuses Table</h2>
          <StatusesTable />
        </div>
        <div v-else-if="selectedMenuItem === 'roles'">
          <h2 class="text-2xl font-semibold mb-4">Roles Table</h2>
          <Roles />
        </div>
        <div v-else-if="selectedMenuItem === 'loantypes'">
          <h2 class="text-2xl font-semibold mb-4">Loan Types Table</h2>
          <LoanTypes />
        </div>
        <div v-else-if="selectedMenuItem === 'loanpayments'">
          <h2 class="text-2xl font-semibold mb-4">Loan Payment Table</h2>
          <!-- <MovieGenres /> -->
        </div>
        <div v-else-if="selectedMenuItem === 'loans'">
          <h2 class="text-2xl font-semibold mb-4">Loans Table</h2>
          <Loans />
        </div>
        <div v-else-if="selectedMenuItem === 'shares'">
          <h2 class="text-2xl font-semibold mb-4">Shares Table</h2>
          <Shares />
        </div>
        <div v-else-if="selectedMenuItem === 'sharetransfers'">
          <h2 class="text-2xl font-semibold mb-4">Share Transfer Table</h2>
          <ShareTransfers />
        </div>
        <!-- Add more sections for other menu items -->
  
        <!-- Place additional content for each menu item here -->
      </div>
    </div>
  </template>
  
  <script>
  import SidePanel from '@/components/SidePanel.vue';
  import Home from '@/components/admin/HomeView.vue';

  import UsersTable from '@/components/admin/UsersTable.vue';
  import StatusesTable from '@/components/admin/StatusesTable.vue';

  import ContributionsTable from '@/components/admin/ContributionsTable.vue';
  import LoanRequests from '@/components/admin/LoanRequestsTable.vue';
  import Roles from '@/components/admin/RolesTable.vue';
  import LoanTypes from '@/components/admin/LoanTypesTable.vue';
  import Loans from '@/components/admin/LoansTable.vue';
  import Shares from '@/components/admin/SharesTable.vue';
  import ShareTransfers from '@/components/admin/ShareTransfersTable.vue';
//   import GenresTable from '@/components/admin/GenresTable.vue';
//   import ActorsTable from '@/components/admin/ActorsTable.vue';
//   import MovieActors from '@/components/admin/MovieActorsTable.vue';
//   import MovieGenres from '@/components/admin/MovieGenresTable.vue';



  
  export default {
    created() {
      console.log(this.userRole);
      console.log(this.isAuthenticated);

    // Check if user is authenticated and has admin role
    if (!this.isAuthenticated || this.userRole !== '2') {
      // Redirect to unauthorized page or handle accordingly
      console.log('nop')
      this.$router.push('/member');
    }
  },
  computed: {
    isAuthenticated() {
      // Check if user is authenticated
      return localStorage.getItem('auth_token');
    },
    userRole() {
      // Get user role from local storage or Vuex store
      return localStorage.getItem('role_id');
    }
  },
    components: {
      SidePanel,
      Home,
      UsersTable,
      ContributionsTable,
      LoanRequests,
      StatusesTable,
      LoanTypes,
      Roles,
      Loans,
      Shares,
      ShareTransfers
    //   GenresTable,
    //   MoviesTable,
    //   ActorsTable,
    //   MovieActors,
    //   MovieGenres
      // Import other components for different sections
    },
    data() {
      return {
        selectedMenuItem: 'home' // Default selected menu item
      };
    },
    methods: {
      handleMenuItemSelected(item) {
        this.selectedMenuItem = item;
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add scoped styles if needed */
  </style>
  