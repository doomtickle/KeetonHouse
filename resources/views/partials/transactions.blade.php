<h2 class="title">Transactions</h2>
<p class="subtitle">Create a new transaction record by completing the form below.</p>
<section class="section">
    @include('partials.createTransactionFormShow')
</section>
<div class="column">
    <section class="section">
        <p class="subtitle notification is-info">Below is a list of all transactions
            for {{ $resident->first_name }} {{ $resident->last_name }}</p>
        <table id="transaction-table" class="table">
            <thead>
            <tr>
                <th>Transaction #</th>
                <th>Date</th>
                <th>Reason</th>
                <th>Debit</th>
                <th>Credit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($resident->transactions as $transaction)
                <tr class="has-text-centered">
                    <th>{{ $transaction->id}}</th>
                    <td>{{ Carbon\Carbon::parse($transaction->date)->format('F d, Y') }}</td>
                    <td>{{ $transaction->reason }}</td>
                    @if($transaction->debit > 0)
                        <td class="debit"> - ${{ number_format($transaction->debit / 100, 2, '.', ',') }}</td>
                    @else
                        <td>&nbsp;</td>
                    @endif
                    @if($transaction->credit > 0)
                        <td class="credit">${{ number_format($transaction->credit / 100, 2, '.', ',') }}</td>
                    @else
                        <td>&nbsp;</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
    <hr>
    <p class="column is-offset-three-quarters is-2 has-text-right">
        @php
            $balanceColor = 'debit';
            $currentBalance = $resident->transactions()->sum('credit') / 100 - $resident->transactions()->sum('debit') / 100;
            if($currentBalance > 0)
                $balanceColor = 'credit';
        @endphp
        <strong>Current Balance:</strong>
        <span class="{{ $balanceColor }}" id="current_balance">${{ number_format($currentBalance, 2, '.', ',') }}</span>
    </p>
</div>