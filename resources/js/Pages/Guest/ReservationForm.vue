<template>
    <div>
        <TopNavigation />
        <div class="bg-cover bg-center min-h-[70vh]" style="background-image: url('/images/banner-no-overlay.png');">
            <div class="flex items-center justify-center h-full">
                <div class="bg-teal-600 shadow-lg rounded-lg p-8 max-w-lg w-full mx-4 my-12">
                    <h1 class="text-3xl font-bold text-center text-white mb-6">Book Your Stay</h1>
                    <form @submit.prevent="submitForm" class="space-y-6">
                        <!-- Check-in Date -->
                        <div>
                            <label for="checkin_date" class="block text-white font-medium">Check-in Date:</label>
                            <input
                                v-model="form.checkin_date"
                                type="date"
                                id="checkin_date"
                                :min="today"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring focus:ring-orange-200"
                                @focus="openCalendar($event)"
                                @change="updateCheckoutMinDate"
                                required
                            />
                        </div>

                        <!-- Check-out Date -->
                        <div>
                            <label for="checkout_date" class="block text-white font-medium">Check-out Date:</label>
                            <input
                                v-model="form.checkout_date"
                                type="date"
                                id="checkout_date"
                                :min="checkoutMinDate"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 focus:ring focus:ring-orange-200"
                                @focus="openCalendar($event)"
                                required
                            />
                        </div>

                        <!-- Guest Count with Increment/Decrement -->
                        <div>
                            <label for="guest_count" class="block text-white font-medium mb-2">Number of Guests:</label>
                            <div class="flex items-center space-x-2">
                                <button
                                    type="button"
                                    class="bg-white text-gray-800 h-8 w-8 rounded-full flex items-center justify-center hover:bg-gray-400 transition-colors"
                                    @click="decrementGuests"
                                    :disabled="form.guest_count <= 1"
                                >
                                    <font-awesome-icon :icon="['fas', 'minus']" />
                                </button>
                                <input
                                    v-model="form.guest_count"
                                    type="number"
                                    id="guest_count"
                                    class="w-16 text-center p-2 border-t border-b border-gray-300 focus:outline-none focus:border-orange-500"
                                    readonly
                                />
                                <button
                                    type="button"
                                    class="bg-white text-gray-800 h-8 w-8 rounded-full flex items-center justify-center hover:bg-gray-400 transition-colors"
                                    @click="incrementGuests"
                                >
                                    <font-awesome-icon :icon="['fas', 'plus']" />
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full bg-orange-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-orange-700 transition-colors"
                        >
                            Search Available Rooms
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TopNavigation from '../../Shared/TopNavigation.vue';
import { format } from 'date-fns';

export default {
    components: {
        TopNavigation
    },
    data() {
        return {
            form: {
                checkin_date: '',
                checkout_date: '',
                guest_count: 1,
            },
            today: format(new Date(), 'yyyy-MM-dd'),
            checkoutMinDate: ''
        };
    },
    methods: {
        submitForm() {
            this.$inertia.post(this.route('rooms.available'), this.form);
        },
        updateCheckoutMinDate() {
            if (this.form.checkin_date) {
                const checkinDate = new Date(this.form.checkin_date);
                const checkoutDate = new Date(checkinDate);
                checkoutDate.setDate(checkoutDate.getDate() + 1);
                this.checkoutMinDate = format(checkoutDate, 'yyyy-MM-dd');
                if (new Date(this.form.checkout_date) <= checkinDate) {
                    this.form.checkout_date = '';
                }
            }
        },
        incrementGuests() {
            this.form.guest_count += 1;
        },
        decrementGuests() {
            if (this.form.guest_count > 1) {
                this.form.guest_count -= 1;
            }
        },
        // Opens the date picker when the input is clicked
        openCalendar(event) {
            event.target.showPicker(); // Programmatically open the date picker
        }
    }
};
</script>
