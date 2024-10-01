<template>
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation Bar -->
        <nav class="bg-teal-600 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <!-- Logo -->
                <h2 class="md:text-xl text-base font-bold">Dashboard</h2>

                <!-- Navigation Links -->
                <ul class="flex md:space-x-6 space-x-4">
                    <li>
                        <Link href="/admin/" class="hover:text-gray-300"><font-awesome-icon :icon="['fas', 'house']" /></Link>
                    </li>
                    <li>
                        <Link href="/admin/reservations" class="hover:text-gray-300 text-sm md:text-base">Reservations</Link>
                    </li>
                </ul>

                <!-- Logout Button -->
                <form @submit.prevent="logout" class="ml-6">
                    <button type="submit" class="hover:text-gray-300"><font-awesome-icon :icon="['fas', 'power-off']" /></button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 bg-gray-100 md:py-12 md:px-24 p-6">
            <slot></slot> <!-- This is where the page content will be displayed -->
        </main>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'; // Correct import for Inertia's post method

export default {
    components: {
        Link
    },
    methods: {
        logout() {
            Inertia.post('/logout'); // Correct logout method using Inertia
        }
    }
};
</script>
