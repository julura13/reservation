<template>
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-1/4 bg-teal-600 text-white p-6">
            <h2 class="text-xl font-bold mb-4">Admin Dashboard</h2>
            <nav>
                <ul class="space-y-4">
                    <li>
                        <Link href="/admin/" class="hover:text-gray-300">Dashboard</Link>
                    </li>
                    <li>
                        <Link href="/admin/reservations" class="hover:text-gray-300">Reservations</Link>
                    </li>
                </ul>
            </nav>

            <!-- Logout Button -->
            <form @submit.prevent="logout">
                <button type="submit" class="hover:text-gray-300 mt-4">
                    Logout
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="w-3/4 bg-gray-100 p-6">
            <slot></slot> <!-- This is where the page content will be displayed -->
        </main>
    </div>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia'; // Correct import for Inertia's post method

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
