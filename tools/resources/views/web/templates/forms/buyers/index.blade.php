<section class="buyer-registration">
    <h2>Buyer Registration</h2>

    <form>
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="text" name="company_name" placeholder="Company Name">
        <input type="text" name="designation" placeholder="Designation">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="url" name="website" placeholder="Company Website" required>
        <input type="tel" name="phone" placeholder="Phone Number" required>
        <input type="text" name="city" placeholder="City">

        <select name="business_type">
            <option value="">Business Type</option>
            <option>Travel Agent</option>
            <option>Tour Operator</option>
            <option>Corporate</option>
            <option>Hotelier</option>
            <option>Other</option>
        </select>

        <select name="looking_for">
            <option value="">What are you looking for?</option>
            <option>Networking</option>
            <option>Partnerships</option>
            <option>New Products / Destinations</option>
        </select>

        <p>Hosted Buyer Benefits?</p>
        <label><input type="radio" name="hosted_buyer" value="Yes"> Yes</label>
        <label><input type="radio" name="hosted_buyer" value="No"> No</label>

        <div id="hosted-fields">
            <p>Do you make purchase decisions?</p>
            <label><input type="radio" name="purchase_decision" value="Yes"> Yes</label>
            <label><input type="radio" name="purchase_decision" value="No"> No</label>

            <input type="text" name="preferred_destination" placeholder="Preferred Destinations">

            <p>Need travel and accommodation?</p>
            <label><input type="radio" name="travel_accommodation" value="Yes"> Yes</label>
            <label><input type="radio" name="travel_accommodation" value="No"> No</label>
        </div>

        <button type="submit">Submit</button>
    </form>
</section>

<style>
    .buyer-registration {
        max-width: 800px;
        margin: auto;
    }

    .buyer-registration form {
        display: grid;
        gap: 15px;
    }

    .buyer-registration input,
    .buyer-registration select {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
    }

    button {
        padding: 12px 20px;
        cursor: pointer;
    }
</style>