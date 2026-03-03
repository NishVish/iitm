<h2>Edit Event</h2>
<form method="post" action="events/update/<?= $event['event_id'] ?>">
    Name: <input type="text" name="name" value="<?= $event['name'] ?>"><br>
    Year: <input type="number" name="year" value="<?= $event['year'] ?>"><br>
    B2B Constrain: <input type="text" name="b2b_constrain" value="<?= $event['b2b_constrain'] ?>"><br>
    Venue Details: <input type="text" name="venue_details" value="<?= $event['venue_details'] ?>"><br>
    Venue Booking Details: <input type="text" name="venue_booking_details" value="<?= $event['venue_booking_details'] ?>"><br>
    Coordinator: <input type="text" name="coordinator" value="<?= $event['coordinator'] ?>"><br>
    Start Date: <input type="date" name="start_date" value="<?= $event['start_date'] ?>"><br>
    End Date: <input type="date" name="end_date" value="<?= $event['end_date'] ?>"><br>
    <button type="submit">Update</button>
</form>
