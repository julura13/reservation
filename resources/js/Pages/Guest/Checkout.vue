<template>
    <div>
        <TopNavigation />
        <div class="min-h-screen bg-gray-100 py-10">
            <div class="container mx-auto max-w-lg">
                <div class="bg-white shadow-lg rounded-lg p-8">
                    <h1 class="text-3xl font-bold text-center text-teal-600 mb-6">Complete Your Reservation</h1>

                    <!-- Display room and reservation details -->
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">{{ room.name }}</h2>
                        <p class="text-gray-600">Check-in: {{ checkin_date }}</p>
                        <p class="text-gray-600">Check-out: {{ checkout_date }}</p>
                        <p class="text-gray-600">Number of Guests: {{ guest_count }}</p>
                    </div>

                    <!-- Guest Details Form -->
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Your Details</h2>
                    <form @submit.prevent="submitForm" class="space-y-6">
                        <div>
                            <label for="guest_name" class="block text-gray-700 font-medium">Full Name:</label>
                            <input
                                v-model="form.guest_name"
                                type="text"
                                id="guest_name"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500"
                                required
                            />
                        </div>
                        <div>
                            <label for="guest_email" class="block text-gray-700 font-medium">Email:</label>
                            <input
                                v-model="form.guest_email"
                                type="email"
                                id="guest_email"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500"
                                required
                            />
                        </div>
                        <div>
                            <label for="guest_phone" class="block text-gray-700 font-medium">Phone Number:</label>
                            <input
                                v-model="form.guest_phone"
                                type="tel"
                                id="guest_phone"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500"
                                required
                            />
                        </div>

                        <!-- Hidden reservation fields -->
                        <input type="hidden" v-model="form.room_id" />
                        <input type="hidden" v-model="form.start_date" />
                        <input type="hidden" v-model="form.end_date" />
                        <input type="hidden" v-model="form.number_of_rooms" />

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full bg-orange-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-orange-700 transition-colors"
                        >
                            Confirm Reservation
                        </button>
                    </form>

                    <!-- Cancel Reservation Button -->
                    <div class="mt-4 text-center">
                        <button @click="cancelReservation" class="bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700">
                            Cancel Reservation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import TopNavigation from '../../Shared/TopNavigation.vue';

export default {
    props: {
        room: Object,
        checkin_date: String,
        checkout_date: String,
        guest_count: Number,
        total_nights: Number
    },
    components: {
        TopNavigation
    },
    data() {
        return {
            form: {
                guest_name: '',
                guest_email: '',
                guest_phone: '',
                room_id: this.room.id,
                start_date: this.checkin_date,
                end_date: this.checkout_date,
                number_of_rooms: 1
            }
        };
    },
    methods: {
        submitForm() {
            this.$inertia.post(this.route('reservation.confirm'), {
                ...this.form,
                guest_count: this.guest_count
            });
        },
        cancelReservation() {
            if (confirm('Are you sure you want to cancel your reservation?')) {
                Inertia.post(this.route('reservation.cancel', {reservation: this.room.id}));
            }
        }
    }
};
</script>
