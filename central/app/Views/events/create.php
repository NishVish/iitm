<h2>Create Event</h2>
<form method="post" action="<?= site_url('events/store') ?>">
    Name: <input type="text" name="name"><br>
    Year: <input type="number" name="year"><br>
    B2B Constrain: <input type="text" name="b2b_constrain"><br>
    Venue Details: <input type="text" name="venue_details"><br>
    Venue Booking Details: <input type="text" name="venue_booking_details"><br>
    Coordinator: <input type="text" name="coordinator"><br>
    Start Date: <input type="date" name="start_date"><br>
    End Date: <input type="date" name="end_date"><br>
    <button type="submit">Save</button>
</form>
