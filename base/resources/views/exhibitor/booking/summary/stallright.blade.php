<!-- Amount Breakdown -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

    <div class="px-5 py-4 border-b border-slate-200">
        <h3 class="text-sm font-bold text-slate-900">
            Amount Breakdown
        </h3>
    </div>

    <div class="p-5 space-y-4">

        <div class="flex justify-between items-center">
            <span class="text-sm text-slate-500">
                Base Price
            </span>
            <span class="text-sm font-semibold text-slate-800">
                ₹{{ number_format((float) $stall->stall_price, 2) }}
            </span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-sm text-slate-500">
                Original Amount
            </span>
            <span class="text-sm font-semibold text-slate-800">
                ₹{{ number_format((float) $stall->original_amount, 2) }}
            </span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-sm text-slate-500">
                Discount
            </span>
            <span class="text-sm font-semibold text-emerald-600">
                -₹{{ number_format((float) $stall->discount_amount, 2) }}
            </span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-sm text-slate-500">
                GST
            </span>
            <span class="text-sm font-semibold text-slate-800">
                ₹{{ number_format((float) $stall->gst_amount, 2) }}
            </span>
        </div>

        @if(!empty($stall->discount_code))
            <div class="pt-3 border-t border-slate-100">
                <div class="text-xs text-slate-400">
                    Discount Code
                </div>
                <div class="text-sm font-semibold text-indigo-600 mt-1">
                    {{ $stall->discount_code }}
                </div>
            </div>
        @endif

    </div>

</div>


<!-- Total Amount -->
<div class="rounded-xl border border-indigo-200 bg-indigo-50 shadow-sm overflow-hidden">

    <div class="p-6">

        <div class="flex items-center justify-between">

            <div>
                <div class="text-xs font-bold uppercase tracking-wider text-indigo-500">
                    Total Amount
                </div>

                <div class="text-xs text-indigo-400 mt-1">
                    Total payable amount
                </div>
            </div>

            <div class="text-3xl font-bold text-indigo-700">
                ₹{{ number_format((float) $stall->final_price, 2) }}
            </div>

        </div>

    </div>

</div>


<!-- Due Amount -->
<div class="rounded-xl border border-rose-200 bg-rose-50 shadow-sm overflow-hidden">

    <div class="p-6">

        <div class="flex items-center justify-between">

            <div>
                <div class="text-xs font-bold uppercase tracking-wider text-rose-500">
                    Due Amount
                </div>

                <div class="text-xs text-rose-400 mt-1">
                    Remaining amount to be paid
                </div>
            </div>

            <div class="text-3xl font-bold text-rose-600">
                ₹{{ number_format((float) $stall->due_amount, 2) }}
            </div>

        </div>

    </div>

</div>