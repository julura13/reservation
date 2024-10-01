<template>
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="container mx-auto max-w-lg bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-3xl font-bold text-center text-teal-600 mb-6">Reservation Confirmed!</h1>

            <!-- Display reservation reference number -->
            <div class="text-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Reservation Reference:</h2>
                <p class="text-orange-600 font-bold text-2xl">{{ reservation.reference_number }}</p>
            </div>

            <!-- Display reservation details (label and value next to each other) -->
            <div class="space-y-4">
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Guest Name:</h2>
                    <p class="text-gray-600">{{ reservation.guest.name }}</p>
                </div>
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Email:</h2>
                    <p class="text-gray-600">{{ reservation.guest.email }}</p>
                </div>
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Phone:</h2>
                    <p class="text-gray-600">{{ reservation.guest.phone_number }}</p>
                </div>
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Room:</h2>
                    <p class="text-gray-600">{{ reservation.room.name }}</p>
                </div>
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Check-in Date:</h2>
                    <p class="text-gray-600">{{ reservation.start_date }}</p>
                </div>
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Check-out Date:</h2>
                    <p class="text-gray-600">{{ reservation.end_date }}</p>
                </div>
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Number of Rooms:</h2>
                    <p class="text-gray-600">{{ reservation.number_of_rooms }}</p>
                </div>
            </div>

            <!-- Print button -->
            <div class="mt-8 text-center">
                <button @click="printDetails" class="bg-orange-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-orange-700 no-print">
                    Print Reservation Details
                </button>
            </div>

            <!-- Back to Home button (hidden on print) -->
            <div class="mt-4 text-center">
                <button @click="goHome" class="bg-teal-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 no-print">
                    Back to Home
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        reservation: Object
    },
    methods: {
        printDetails() {
            window.print(); // Trigger browser print functionality
        },
        goHome() {
            this.$inertia.visit('/'); // Redirect to home page
        }
    }
};
</script>

<style>
/* CSS to hide the Back to Home button when printing */
@media print {
    .no-print {
        display: none;
    }
}
</style>
