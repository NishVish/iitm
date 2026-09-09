@if(!empty($stall['payments']))

    <tr>
        <td></td>

        <td colspan="11">

            <strong>Payment History</strong>

            <table class="table table-bordered table-sm mt-2 mb-0">

                <thead class="table-secondary">
                    <tr>
                        <th>ID</th>
                        <th>Payment For</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Transaction ID</th>
                        <th>UTR</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($stall['payments'] as $record)

                        <tr>
                            <td>
                                {{ $record['id'] ?? '-' }}
                            </td>

                            <td>
                                {{ $record['payment_for'] ?? '-' }}
                            </td>

                            <td>
                                {{ $money($record['amount'] ?? 0) }}
                            </td>

                            <td>
                                {{ $record['payment_method'] ?? '-' }}
                            </td>

                            <td>
                                {{ $record['transaction_id'] ?? '-' }}
                            </td>

                            <td>
                                {{ $record['utr_id'] ?? '-' }}
                            </td>

                            <td>
                                {{ $record['payment_date'] ?? '-' }}
                            </td>

                            <td>
                                {{ ucfirst($record['status'] ?? 'pending') }}
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </td>
    </tr>

@endif