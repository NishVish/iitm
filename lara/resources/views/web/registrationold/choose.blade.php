<div class="hero">
    <h1>Welcome to IITM India 2026</h1>
    <p>Your gateway to the vast Indian Travel & Tourism Market. Select your method of participation below to get
        started.</p>
</div>

<!-- Question Guide -->

<div class="options-container">

    <div class="card">
        <div class="card-image ex-img"></div>

        <div class="card-content">
            <h2>Exhibitor</h2>

            <p>Book a stall and showcase your brand to global travel trade leaders.</p>

            <ul class="benefits">
                <li>Promote your products & services</li>
                <li>Meet travel buyers and partners</li>
                <li>Increase brand visibility</li>
                <li>Generate business leads</li>
            </ul>

            <a href="{{ url('exhibitor') }}" class="btn btn-red">
                Buy a Stall
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-image vis-img"></div>

        <div class="card-content">
            <h2>Visitor</h2>

            <p>Network with exhibitors and explore destinations and business opportunities.</p>

            <ul class="benefits">
                <li>Explore travel destinations & offers</li>
                <li>Connect with industry professionals</li>
                <li>Discover new business opportunities</li>
                <li>Attend networking sessions</li>
            </ul>
            <a href="{{ url('eventlist') }}" class="btn btn-white">
                Get Entry Badge
            </a>

            <!-- <button onclick="{{ url('register/eventlist') }}" class="btn btn-white">
                    Get Entry Badge
                </button> -->
        </div>
    </div>

</div>




</body>

</html>