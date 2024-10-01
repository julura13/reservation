<template>
    <div>
        <TopNavigation />
        <div class="min-h-screen bg-gray-100 py-10">
            <div class="container mx-auto max-w-lg bg-white shadow-lg rounded-lg p-8">
                <h1 class="text-3xl font-bold text-center text-teal-600 mb-6">Complete Your Payment</h1>

                <!-- Fake Card Payment Form -->
                <form @submit.prevent="submitPayment" class="space-y-6">
                    <div>
                        <label for="card_number" class="block text-gray-700 font-medium">Card Number:</label>
                        <input
                            v-model="card.card_number"
                            type="text"
                            id="card_number"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500"
                            readonly
                        />
                    </div>
                    <div class="flex space-x-4">
                        <div>
                            <label for="expiry" class="block text-gray-700 font-medium">Expiry Date:</label>
                            <input
                                v-model="card.expiry"
                                type="text"
                                id="expiry"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500"
                                readonly
                            />
                        </div>
                        <div>
                            <label for="cvv" class="block text-gray-700 font-medium">CVV:</label>
                            <input
                                v-model="card.cvv"
                                type="text"
                                id="cvv"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-orange-500"
                                readonly
                            />
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-orange-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-orange-700 transition-colors"
                    >
                        Pay Now
                    </button>
                </form>

                <!-- Cancel Payment Button -->
                <div class="mt-4 text-center">
                    <button @click="cancelPayment" class="bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700">
                        Cancel Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import TopNavigation from '../../Shared/TopNavigation.vue';

export default {
    props: {
        fakeCard: Object
    },
    data() {
        return {
            card: {
                card_number: this.fakeCard.card_number,
                expiry: this.fakeCard.expiry,
                cvv: this.fakeCard.cvv
            }
        };
    },
    components: {
        TopNavigation
    },
    methods: {
        submitPayment() {
            this.$inertia.post(this.route('payment.process'));
        },
        cancelPayment() {
            if (confirm('Are you sure you want to cancel the payment?')) {
                this.$inertia.post(this.route('payment.cancel'));
            }
        }
    }
};
</script>
