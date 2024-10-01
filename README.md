<h1>Introduction</h1>

<h2>Guest Side</h2>

<p>This is a basic reservation system where a guest can select a check-in date, check-out date, and number of guests. This then goes to the available rooms page where we display the rooms that are available (not booked yet) and suitable for the amount of guests. This is very basic and shows the amount for the room per night and then a total according to the number of nights chosen. The guest selects the room they want to book and then gets redirected to the guest information form. Here the guest fills in their details that are all required. They have an option to confirm the reservation and go to the payments page, or they can cancel the reservation. If they cancel, they get redirected back to the home page and a message is shown. If they confirm the reservation, they will go to the payment page. On the payment page, we have fake credit card details in place so for demo you can just click pay now. Once "Pay Now" has been selected, a reservation confirmation page is shown with all the details and a randomly generated reference number. You have the option to print the page where we hide the buttons to not show on the printed page. The system will also fire a confirmation email to the guest with the booking details. Other than this, you can click the button to go back to the home page.</p>

<h2>Admin Side</h2>

<p>As an admin user, you can click on the avatar button in the top navigation then click login. This will take you to the login page. Here you can fill in the user details to log in. The demo user that has been seeded is: admin@test.com with password <code>4dm1n123!!</code>.</p>

<p>On the dashboard, bookings that are upcoming in the next 7 days are shown. It shows a summary of the total bookings, total rooms booked, and the total number of guests. It also shows cards for each booking.</p>

<p>In the top navigation, there is a home button — takes you back to the dashboard landing page, a reservations option to show more details about the reservations, and a power button to log out.</p>

<p>The reservations page shows by default the booked reservations. There is a search filter to search on reference number, guest name, and room type. There is also a filter button to select between the reservation statuses of All, Booked, Pending, Checked in, Canceled, and Done.</p>

<h2>Status Explanation:</h2>

<ul>
<li><strong>All</strong>: Self-explanatory</li>
<li><strong>Booked</strong>: Guests who have booked a reservation and fully paid.</li>
<li><strong>Pending</strong>: Guests who have booked but payment has not yet been made.</li>
<li><strong>Checked in</strong>: An admin has the option to change the booked status to "checked in." This option is only available if today’s date is equal to the check-in date of the reservation.</li>
<li><strong>Canceled</strong>: When a guest has canceled on the payment page, the booking is marked as canceled.</li>
<li><strong>Done</strong>: An admin has the option to mark a reservation as done. This is only available if today’s date is equal to the check-out date.</li>
</ul>

<h2>The Architecture Chosen</h2>

<p>For this project, I did a video tutorial series to familiarize myself with Vue and Inertia. My day-to-day experience is more with Alpine and Livewire, so I chose the VILT stack. I had before this done a few small Vue home projects and helped a friend with a Vue app. Tailwind I’m very familiar with. My database I used is MySQL, but the system should work with most databases. For the email sending I use Laravel Queues.</p>

<p>I had to google a lot but managed to get something working in the end. This is the 4th version or start of this project. I messed up the previous Laravel installs too much.</p>

<h2>Installation</h2>

<p>You will be able to access the repository at https://github.com/julura13/reservation. Here you can pull or download the zip file. I will also include a zip file in my email.</p>

<p>Unzip the folder and go into the folder. Here you have to run <code>composer install</code> and <code>npm install</code>. Most of the time, you will also need to run <code>php artisan generate:key</code>. You can copy the <code>.env.example</code> and rename it to <code>.env</code>, where some basic settings are pre-populated.</p>

<p>Now you have to create a database locally. I have used MySQL, but this should work with most DB setups. I did create factories and a few seeders to set up reservations. Just run <code>php artisan migrate --seed</code> if you haven't already migrated, or <code>php artisan migrate:fresh --seed</code> if you did.</p>

<p>The system uses queues to send the guest emails, so remember to check the queue connection is set to the database. Once that is done, run the queues by doing <code>php artisan queue:work</code>.</p>

<p>To initialize the npm assets, run <code>npm run build &amp;&amp; npm run dev</code>. I’m using Valet on my machine, but this should give a URL in the terminal to run the project.</p>

<h3>Demo Admin User Details</h3>

<ul>
<li>Email: admin@test.com</li>
<li>Password: <code>4dm1n123!!</code></li>
</ul>

<p>The online version is also available at: <a href="https://reservations.julura.site">reservations.julura.site</a>.</p>
