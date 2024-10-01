<template>
    <AdminDashboard>
        <h2 class="text-2xl font-bold mb-4">Upcoming Booked Reservations (next 7 days)</h2>

        <!-- Summary Section (Total Reservations, Guests and Rooms) -->
        <div class="flex md:flex-row flex-col md:space-x-8 space-y-4 md:space-y-0 mb-6">
            <div class="p-4 bg-white shadow rounded-lg">
                <h2 class="text-xl font-bold">Total Reservations</h2>
                <p class="text-2xl">{{ totalReservations }}</p>
            </div>
            <div class="p-4 bg-white shadow rounded-lg">
                <h2 class="text-xl font-bold">Total Rooms</h2>
                <p class="text-2xl">{{ totalRooms }}</p>
            </div>
            <div class="p-4 bg-white shadow rounded-lg">
                <h2 class="text-xl font-bold">Total Guests</h2>
                <p class="text-2xl">{{ totalGuests }}</p>
            </div>
        </div>

        <!-- Upcoming Booked Reservations Section -->
        <div>
            <div v-if="reservations && reservations.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="reservation in reservations" :key="reservation.id" class="p-4 bg-white shadow rounded-lg">
                    <h3 class="font-bold">{{ reservation.guest.name }}</h3>
                    <p>Room: {{ reservation.room.name }}</p>
                    <p>Total Guests: {{ reservation.number_of_guests }}</p>
                    <p>Check-in: {{ reservation.start_date }}</p>
                    <p>Check-out: {{ reservation.end_date }}</p>
                    <p>Days Booked: {{ calculateDays(reservation.start_date, reservation.end_date) }}</p>
                    <p>Status: {{ reservation.status }}</p>
                </div>
            </div>
            <div v-else>
                <p>No upcoming booked reservations found.</p>
            </div>
        </div>
    </AdminDashboard>
</template>

<script>
import AdminDashboard from '../../Layouts/AdminDashboard.vue';
import { differenceInCalendarDays, parseISO } from 'date-fns';

export default {
    props: {
        reservations: {
            type: Array,
            default: () => []
        },
        totalReservations: {
            type: Number,
            default: 0
        },
        totalGuests: {
            type: Number,
            default: 0
        },
        totalRooms: {
            type: Number,
            default: 0
        }
    },
    methods: {
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
