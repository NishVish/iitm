@if($event1)
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row align-items-center">

                <!-- <div class="col-md-3 text-center mb-3 mb-md-0">
                            <img src="{{ $event1->event_image }}" alt="{{ $event1->name }}" class="img-fluid rounded"
                                style="max-height:150px;">
                        </div> -->

                <div class="col-md-9">
                    <h3 class="text-white mb-3">{{ $event1->name }}</h3>

                    <p class="mb-2">
                        <i class="fa fa-calendar"></i>
                        <strong>Dates:</strong>
                        {{ date('d M Y', strtotime($event1->start_date)) }}
                        -
                        {{ date('d M Y', strtotime($event1->end_date)) }}
                    </p>

                    <p class="mb-0">
                        <i class="fa fa-map-marker"></i>
                        <strong>Venue:</strong>
                        {{ $event1->venue_details }}
                    </p>
                </div>

            </div>
        </div>
    </footer>
@endif