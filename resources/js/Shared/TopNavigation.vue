<template>
    <nav class="bg-teal-600 p-4">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <!-- Logo as a clickable link -->
                <div class="flex items-center">
                    <a href="/" class="text-white text-xl font-bold hover:text-gray-300 transition-colors">
                        Reservation System
                    </a>
                </div>

                <!-- Avatar & Dropdown -->
                <div class="ml-3 relative">
                    <button
                        @click="toggleDropdown"
                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-white"
                    >
                        <!-- Use FontAwesome Icon for Avatar, updated size -->
                        <font-awesome-icon icon="user" class="text-white h-4 w-4" />
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        v-if="dropdownOpen"
                        @click.away="closeDropdown"
                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                    >
                        <a
                            href="#"
                            @click="redirectToLogin"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            dropdownOpen: false,
        };
    },
    methods: {
        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
        },
        closeDropdown() {
            this.dropdownOpen = false;
        },
        redirectToLogin() {
            this.$inertia.get(this.route('login'));
        },
    },
};
</script>
