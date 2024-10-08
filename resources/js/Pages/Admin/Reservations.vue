<template>
    <AdminDashboard>
        <h1 class="text-2xl font-bold mb-6">Manage Reservations</h1>

        <!-- Search and Filter Section -->
        <div class="flex flex-col md:flex-row md:space-x-8 space-y-4 md:space-y-0 mb-4">
            <input
                type="text"
                v-model="search"
                @input="applyFilters"
                placeholder="Search reservations..."
                class="p-2 border rounded-lg md:w-1/3 w-full"
            />
            <select v-model="selectedStatus" @change="applyFilters" class="p-2 border rounded-lg w-32">
                <option value="">All</option>
                <option value="booked">Booked</option>
                <option value="pending">Pending</option>
                <option value="checked_in">Checked In</option>
                <option value="canceled">Canceled</option>
                <option value="done">Done</option>
            </select>
        </div>

        <!-- Table of Reservations -->
      <div v-if="sortedReservations.length > 0" class="overflow-x-auto">
        <table class="min-w-full bg-white">
          <thead>
          <tr>
            <th class="px-4 py-2 border">Reference</th>
            <th class="px-4 py-2 border">Guest Name</th>
            <th class="px-4 py-2 border">Room</th>
            <th class="px-4 py-2 border">Check-in Date</th>
            <th class="px-4 py-2 border">Check-out Date</th>
            <th class="px-4 py-2 border">Days Till Arrival</th>
            <th class="px-4 py-2 border">Status</th>
            <th class="px-4 py-2 border">Action</th> <!-- Action column for "Mark as Done" and "Checked In" -->
          </tr>
          </thead>
          <tbody>
          <tr v-for="reservation in sortedReservations" :key="reservation.id" class="text-center">
            <td class="px-4 py-2 border">{{ reservation.reference_number }}</td>
            <td class="px-4 py-2 border">{{ reservation.guest.name }}</td>
            <td class="px-4 py-2 border">{{ reservation.room.name }}</td>
            <td class="px-4 py-2 border">{{ reservation.start_date }}</td>
            <td class="px-4 py-2 border">{{ reservation.end_date }}</td>
            <td class="px-4 py-2 border">{{ showDaysTillArrival(reservation) }}</td>
            <td class="px-4 py-2 border">{{ capitalizeStatus(reservation.status) }}</td>
            <td class="px-4 py-2 border">
              <!-- Mark as Done button only when today === checkout_date -->
              <button v-if="isLastDay(reservation.end_date) && reservation.status !== 'done'"
                      @click="markAsDone(reservation.id)"
                      class="bg-orange-600 text-white px-4 py-1 rounded hover:bg-blue-700">
                Mark as Done
              </button>
              <!-- Mark as Checked in button only when today === check_in date -->
              <button v-if="isCheckInDay(reservation.start_date) && reservation.status !== 'checked_in'"
                      @click="markAsCheckedIn(reservation.id)"
                      class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700">
                Mark as Checked In
              </button>
            </td>
          </tr>
          </tbody>
        </table>
      </div>


      <!-- No Reservations Found -->
        <div v-else>
            <p>No reservations found.</p>
        </div>
    </AdminDashboard>
</template>

<script>
import AdminDashboard from '../../Layouts/AdminDashboard.vue';
import { differenceInCalendarDays, format, parseISO } from 'date-fns';
import axios from 'axios';

export default {
    props: {
        reservations: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            search: '',
            selectedStatus: 'booked', // Default to "booked"
            filteredReservations: []
        };
    },
    watch: {
        reservations: {
            handler() {
                this.applyFilters();
            },
            immediate: true
        }
    },
    computed: {
        sortedReservations() {
            // Sort filtered reservations by the start date
            return this.filteredReservations.sort((a, b) => {
                return new Date(a.start_date) - new Date(b.start_date);
            });
        }
    },
    methods: {
        applyFilters() {
            this.filteredReservations = this.reservations.filter(reservation => {
                const matchesSearch = reservation.guest.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    reservation.room.name.toLowerCase().includes(this.search.toLowerCase()) || reservation.reference_number.toLowerCase().includes(this.search.toLowerCase());
                const matchesStatus = this.selectedStatus === '' || reservation.status === this.selectedStatus;

                return matchesSearch && matchesStatus;
            });
        },
        showDaysTillArrival(reservation) {
            if (reservation.status !== 'booked') {
                return ''; // Blank if the status is not "booked"
            }

            const checkInDate = parseISO(reservation.start_date);
            const today = new Date();
            const days = differenceInCalendarDays(checkInDate, today);

            if (days < 0) {
                return ''; // Blank for past reservations
            } else if (days === 0) {
                return 'Today';
            } else if (days === 1) {
                return 'Tomorrow';
            } else {
                return `${days} days`;
            }
        },
        isCheckInDay(startDate) {
            const today = format(new Date(), 'yyyy-MM-dd');
            return today === format(parseISO(startDate), 'yyyy-MM-dd');
        },
        isLastDay(endDate) {
            const today = format(new Date(), 'yyyy-MM-dd');
            return today === format(parseISO(endDate), 'yyyy-MM-dd');
        },
        markAsDone(reservationId) {
            axios.post(`/admin/reservations/${reservationId}/mark-done`)
                .then(() => {
                    this.$inertia.reload(); // Reload the page after marking as done
                })
                .catch(error => {
                    console.error('Error marking reservation as done:', error);
                });
        },
        markAsCheckedIn(reservationId) {
            axios.post(`/admin/reservations/${reservationId}/mark-checked-in`)
                .then(() => {
                    this.$inertia.reload(); // Reload the page after marking as checked in
                })
                .catch(error => {
                    console.error('Error marking reservation as checked in:', error);
                });
        },
        capitalizeStatus(status) {
            return status.charAt(0).toUpperCase() + status.slice(1);
        }
    },
    components: {
        AdminDashboard
    }
};
</script>
