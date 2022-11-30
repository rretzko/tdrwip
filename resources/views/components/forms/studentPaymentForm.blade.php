@props([
'registrants'
])
<form method="post" action="{{ route('participationfees.payment') }}"
      style="border: 1px solid black; padding: 1rem; background-color: rgba(0,0,0,0.05);"
>
    @csrf
    <h3 style="font-weight: bold;">Add Cash/Check Payment</h3>

    <div class="input-group" style="display: flex; flex-direction: column;">
        <label for="registrant_id">Select Student</label>
        <select name="registrant_id" style="max-width: 16rem;">
            @forelse($registrants AS $registrant)
                <option value="{{ $registrant->id }}">{{ $registrant->programname }}</option>
            @empty
                <option value="0">No students found</option>
            @endforelse
        </select>
    </div>

    <div class="input-group" style="display: flex; flex-direction: column;">
        <label for="paymenttype_id">Payment Type</label>
        <select name="paymenttype_id" style="max-width: 16rem;">
            <option value="1"`>Cash</option>
            <option value="2">Check</option>
        </select>
    </div>

    <div class="input-group" style="display: flex; flex-direction: column;">
        <label for="amount">Amount</label>
        <input type="text" name="amount" value="25" style=" @error('amount') background-color: rgba(255,0,0,0.1) @enderror "/>
        <span style="font-size: smaller;">To reverse an entry, use a negative number (ex. -25).</span>
        @error('amount')
            <div style="color: red;">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="input-group" style="margin-top: 0.5rem;">
        <label></label>
        <input type="submit" name="submit" value="Submit" style="background-color: black; color: white; border-radius: 1rem; padding: 0 1rem;" />
    </div>

    <div id="advisory" style="width: 20rem; min-width: 20rem; max-width: 20rem; font-size: small; margin-top: 1rem;">
        Note: This record is for your internal record-keeping purposes only.
        Individual student non-paypal payments are not passed forward.
    </div>

</form>
