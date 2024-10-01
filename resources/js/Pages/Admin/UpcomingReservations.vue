<template>
    <AdminDashboard>
        <h1 class="text-2xl font-bold mb-6">Upcoming Reservations (Next 7 Days)</h1>
        <div v-if="reservations.length > 0" class="space-y-4">
            <div v-for="reservation in reservations" :key="reservation.id" class="p-4 bg-white rounded shadow">
                <h2 class="font-bold">{{ reservation.guest.name }}</h2>
                <p>Room: {{ reservation.room.name }}</p>
                <p>Check-in: {{ reservation.start_date }}</p>
                <p>Check-out: {{ reservation.end_date }}</p>
                <p>Status: {{ reservation.status }}</p>
            </div>
        </div>
        <div v-else>
            <p>No reservations found for the next 7 days.</p>
        </div>
    </AdminDashboard>
</template>

<script>
import AdminDashboard from '../../Layouts/AdminDashboard.vue';

export default {
    props: {
        reservations: Array
    },
    components: {
        AdminDashboard
    }
};
</script>
