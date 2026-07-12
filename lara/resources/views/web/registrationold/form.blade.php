<div style="display: flex; gap: 20px; align-items: flex-start;">
    @if ($lastSegment != "exhibitor")

        <div style="flex: 1;">
            <!-- Section 1 -->
            <h3>Section 1</h3>
            @include('web.registrationold.eventdetails')
        </div>
    @endif


    <div style="flex: 1;">
        <!-- Section 2 -->
        <h3>Section 2</h3>
        @include('web.registrationold.formparameter')
    </div>

</div>