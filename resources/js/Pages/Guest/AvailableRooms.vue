<template>
    <div>
        <TopNavigation />
        <div class="min-h-screen bg-gray-100 py-10">
            <div class="container mx-auto">
                <!-- Display the check-in and check-out details at the top -->
                <div class="mb-8 bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Reservation Details</h2>
                    <p class="text-gray-600">Check-in: {{ checkin_date }}</p>
                    <p class="text-gray-600">Check-out: {{ checkout_date }}</p>
                    <p class="text-gray-600">Number of Guests: {{ guest_count }}</p>
                    <p class="text-gray-600">Total Nights: {{ total_nights }}</p>
                </div>

                <!-- List of Available Rooms -->
                <h1 class="text-4xl font-bold text-center text-teal-600 mb-10">Available Rooms</h1>
                <div v-if="rooms.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="room in rooms"
                        :key="room.id"
                        class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between"
                    >
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800">{{ room.name }}</h2>
                            <p class="text-gray-600 mt-2">Capacity: {{ room.capacity }} guests</p>
                            <p class="text-gray-600">Price: R{{ Number(room.price_per_night).toFixed(2) }} per night</p>
                            <p class="text-gray-600">Total Cost: R{{ (Number(room.price_per_night) * total_nights).toFixed(2) }}</p>
                        </div>
                        <button
                            @click="proceedToCheckout(room.id)"
                            class="mt-4 bg-orange-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-orange-700 transition-colors"
                        >
                            Select Room
                        </button>
                    </div>
                </div>

                <div v-else class="text-center">
                    <p class="text-xl font-medium text-gray-700">No rooms are available for the selected dates.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TopNavigation from '../../Shared/TopNavigation.vue';

export default {
    props: {
        rooms: Array,
        checkin_date: String,
        checkout_date: String,
        guest_count: Number,
        total_nights: Number
    },
    components: {
        TopNavigation
    },
    methods: {
        proceedToCheckout(roomId) {
            this.$inertia.post(this.route('checkout'), {
                room_id: roomId,
                checkin_date: this.checkin_date,
                checkout_date: this.checkout_date,
                guest_count: this.guest_count,
                total_nights: this.total_nights,
            });
        }
    }

};
</script>
