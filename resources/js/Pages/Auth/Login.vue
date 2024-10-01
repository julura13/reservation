<template>
    <div
        class="min-h-screen bg-cover bg-center flex justify-center items-center"
        style="background-image: url('/images/login-background.png');"
    >
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
            <h1 class="text-3xl font-bold text-center text-teal-600 mb-6">Admin Login</h1>
            <form @submit.prevent="submitForm" class="space-y-6">
                <div>
                    <label for="email" class="block text-gray-700 font-medium">Email:</label>
                    <input
                        v-model="form.email"
                        type="email"
                        id="email"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-teal-500"
                        required
                    />
                </div>
                <div>
                    <label for="password" class="block text-gray-700 font-medium">Password:</label>
                    <input
                        v-model="form.password"
                        type="password"
                        id="password"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-teal-500"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full bg-teal-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-teal-700 transition-colors"
                >
                    Log In
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: '',
                password: ''
            }
        };
    },
    methods: {
        submitForm() {
            this.$inertia.post('/login', this.form); // Adjust route if necessary
        }
    }
};
</script>
