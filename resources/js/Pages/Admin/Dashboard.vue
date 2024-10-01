<template>
    <AdminDashboard>
        <!-- Main Dashboard Heading -->
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>

        <!-- Summary Section (Total Reservations and Guests) -->
        <div class="flex space-x-8 mb-6">
            <div class="p-4 bg-white shadow rounded-lg">
                <h2 class="text-xl font-bold">Total Reservations</h2>
                <p class="text-2xl">{{ totalReservations }}</p>
            </div>
            <div class="p-4 bg-white shadow rounded-lg">
                <h2 class="text-xl font-bold">Total Guests</h2>
                <p class="text-2xl">{{ totalGuests }}</p>
            </div>
        </div>

        <!-- Upcoming Completed Reservations Section -->
        <div>
            <h2 class="text-2xl font-bold mb-4">Upcoming Completed Reservations</h2>
            <div v-if="reservations && reservations.length > 0" class="grid grid-cols-3 gap-4">
                <div v-for="reservation in reservations" :key="reservation.id" class="p-4 bg-white shadow rounded-lg">
                    <h3 class="font-bold">{{ reservation.guest.name }}</h3>
                    <p>Room: {{ reservation.room.name }}</p>
                    <p>Check-in: {{ reservation.start_date }}</p>
                    <p>Check-out: {{ reservation.end_date }}</p>
                    <p>Days Booked: {{ calculateDays(reservation.start_date, reservation.end_date) }}</p> <!-- New field for days booked -->
                    <p>Status: {{ reservation.status }}</p>
                </div>
            </div>
            <div v-else>
                <p>No upcoming completed reservations found.</p>
            </div>
        </div>
    </AdminDashboard>
</template>

<script>
import AdminDashboard from '../../Layouts/AdminDashboard.vue';
import { differenceInCalendarDays, parseISO } from 'date-fns'; // Import date-fns for date calculations

export default {
    props: {
        reservations: {
            type: Array,
            default: () => []  // Ensures a default value of an empty array
        },
        totalReservations: {
            type: Number,
            default: 0  // Ensures a default value of 0
        },
        totalGuests: {
            type: Number,
            default: 0  // Ensures a default value of 0
        }
    },
    methods: {
        // Method to calculate the number of days between check-in and check-out dates
        calculateDays(startDate, endDate) {
            const checkInDate = parseISO(startDate);
            const checkOutDate = parseISO(endDate);
            return differenceInCalendarDays(checkOutDate, checkInDate);
        }
    },
    components: {
        AdminDashboard
    }
};
</script>
