<div class="space-y-5">

    <!-- Event Details -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-sm font-bold text-slate-900">
                Event Details
            </h3>
        </div>

        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

            <div>
                <div class="text-xs text-slate-400 mb-1">
                    Event Name
                </div>
                <div class="text-sm font-semibold text-slate-900">
                    {{ $stall->event_name ?: 'N/A' }}
                </div>
            </div>

            <div>
                <div class="text-xs text-slate-400 mb-1">
                    Event ID
                </div>
                <div class="text-sm font-semibold text-slate-700">
                    {{ $stall->event_id ?: 'N/A' }}
                </div>
            </div>

            <div>
                <div class="text-xs text-slate-400 mb-1">
                    Year
                </div>
                <div class="text-sm font-semibold text-slate-700">
                    {{ $stall->event_year ?: 'N/A' }}
                </div>
            </div>

            <div>
                <div class="text-xs text-slate-400 mb-1">
                    Schedule
                </div>
                <div class="text-sm font-medium text-indigo-600">
                    @if($stall->start_date && $stall->end_date)
                        {{ date('d M Y', strtotime($stall->start_date)) }}
                        -
                        {{ date('d M Y', strtotime($stall->end_date)) }}
                    @else
                        Dates TBD
                    @endif
                </div>
            </div>

            <div class="sm:col-span-2">
                <div class="text-xs text-slate-400 mb-1">
                    Venue
                </div>
                <div class="text-sm text-slate-700">
                    {{ $stall->venue_details ?: 'N/A' }}
                </div>
            </div>

        </div>

    </div>


    <!-- Stall Details -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-sm font-bold text-slate-900">
                Stall Details
            </h3>
        </div>

        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

            <div>
                <div class="text-xs text-slate-400 mb-1">
                    Stall ID
                </div>
                <div class="text-sm font-mono font-semibold text-slate-700">
                    {{ $stall->id }}
                </div>
            </div>

            <div>
                <div class="text-xs text-slate-400 mb-1">
                    Stall Type
                </div>
                <div class="text-sm font-semibold text-slate-700">
                    {{ $stall->stall_type ?: 'N/A' }}
                </div>
            </div>

            <div>
                <div class="text-xs text-slate-400 mb-1">
                    Stall Size
                </div>
                <div class="text-sm font-semibold text-slate-900">
                    {{ $stall->stall_size ?: 'N/A' }}
                    @if($stall->stall_size)
                        <span class="font-normal text-slate-400">
                            sq. ft
                        </span>
                    @endif
                </div>
            </div>

            <div>
                <div class="text-xs text-slate-400 mb-1">
                    Stall Location
                </div>
                <div class="text-sm font-semibold text-slate-700">
                    {{ $stall->stall_location ?: 'N/A' }}
                </div>
            </div>

        </div>

    </div>


    <!-- Fascia & Certificate -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-sm font-bold text-slate-900">
                Fascia & Certificate
            </h3>
        </div>

        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

            <div>
                <div class="text-xs text-slate-400 mb-1">
                    Fascia Name
                </div>
                <div class="text-sm font-semibold text-slate-900">
                    {{ $stall->fascia ?: 'Not Provided' }}
                </div>
            </div>

            <div>
                <div class="text-xs text-slate-400 mb-1">
                    Certificate Name
                </div>
                <div class="text-sm font-semibold text-slate-900">
                    {{ $stall->certificate ?: 'Not Provided' }}
                </div>
            </div>

        </div>

    </div>

</div>