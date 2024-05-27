<template>
<div class="flex h-screen">
    <!-- Side panel -->
    <UserSidePanel @menuItemSelected="handleMenuItemSelected" />

    <!-- Main content area -->
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Display different sections based on selected menu item -->
        <div v-if="selectedMenuItem === 'home'">
            <Home />
        </div>
        <div v-else-if="selectedMenuItem === 'contributions'">
            <Contributions />
        </div>
        <div v-else-if="selectedMenuItem === 'loans'">
            <Loans />
        </div>
        <div v-else-if="selectedMenuItem === 'statements'">
            <h2 class="text-2xl font-semibold mb-4">Statements</h2>
            <Statements />
        </div>

        <!-- Add more sections for other menu items -->

        <!-- Place additional content for each menu item here -->
    </div>
</div>
</template>

<script>
import UserSidePanel from '../components/UserSidePanel.vue';
import Home from '@/components/user/HomeView.vue';
import Contributions from '../components/user/Contributions.vue'
import Statements from '../components/user/Statements.vue'
import Loans from '../components/user/Loans.vue'

export default {
    components: {
        UserSidePanel,
        Home,
        Contributions,
        Statements,
        Loans
    },
    data() {
        return {
            selectedMenuItem: 'home' // Default selected menu item
        };
    },
    computed: {
        isAuthenticated() {
            // Check if user is authenticated
            return !!localStorage.getItem('auth_token');
        }
    },
    created() {
        // Check if user is authenticated
        if (!this.isAuthenticated) {
            console.log('User not authenticated, redirecting...');
            this.$router.push('/');
        }
    },
    methods: {
        handleMenuItemSelected(item) {
            this.selectedMenuItem = item;
        }
    }
}
</script>

<style>
/* Add your styles here */
</style>
