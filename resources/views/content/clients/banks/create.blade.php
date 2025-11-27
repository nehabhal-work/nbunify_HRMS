<form id="leadForm" action="{{ isset($lead) ? route('leads.update', $lead->id) : route('leads.store') }}" method="POST"
    novalidate>
    @csrf
    @if (isset($lead))
        @method('PUT')
    @endif

    <!-- Hidden ID (for update) -->
    <input type="hidden" name="id" value="{{ old('id', $lead->id ?? '') }}">

    <!-- Visible read-only ID (optional) -->
    <div class="mb-3">
        <label for="visible_id" class="form-label">ID</label>
        <input type="text" id="visible_id" class="form-control" value="{{ old('id', $lead->id ?? '') }}" readonly>
    </div>

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" id="name" name="name" value="{{ old('name', $lead->name ?? '') }}"
            class="form-control @error('name') is-invalid @enderror" placeholder="Enter name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Date -->
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" id="date" name="date"
            value="{{ old('date', isset($lead->date) ? \Carbon\Carbon::parse($lead->date)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')) }}"
            class="form-control @error('date') is-invalid @enderror">
        @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Client Name -->
    <div class="mb-3">
        <label for="client_name" class="form-label">Client Name</label>
        <input type="text" id="client_name" name="client_name"
            value="{{ old('client_name', $lead->client_name ?? '') }}"
            class="form-control @error('client_name') is-invalid @enderror" placeholder="Client company or person">
        @error('client_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Requirement (buy/sell/rent) -->
    <div class="mb-3">
        <label for="requirement" class="form-label">Requirement</label>
        <select id="requirement" name="requirement" class="form-select @error('requirement') is-invalid @enderror">
            <option value="">Select requirement</option>
            <option value="buy" {{ old('requirement', $lead->requirement ?? '') == 'buy' ? 'selected' : '' }}>Buy
            </option>
            <option value="sell" {{ old('requirement', $lead->requirement ?? '') == 'sell' ? 'selected' : '' }}>Sell
            </option>
            <option value="rent" {{ old('requirement', $lead->requirement ?? '') == 'rent' ? 'selected' : '' }}>Rent
            </option>
        </select>
        @error('requirement')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Status -->
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
            <option value="">Select status</option>
            <option value="no-response" {{ old('status', $lead->status ?? '') == 'no-response' ? 'selected' : '' }}>
                No-response</option>
            <option value="connected" {{ old('status', $lead->status ?? '') == 'connected' ? 'selected' : '' }}>
                Connected</option>
            <option value="opportunity" {{ old('status', $lead->status ?? '') == 'opportunity' ? 'selected' : '' }}>
                Opportunity</option>
            <option value="not-interested"
                {{ old('status', $lead->status ?? '') == 'not-interested' ? 'selected' : '' }}>Not Interested</option>
            <option value="call-later" {{ old('status', $lead->status ?? '') == 'call-later' ? 'selected' : '' }}>Call
                Later</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Next Schedule (date + time) -->
    <div class="mb-3">
        <label for="next_schedule" class="form-label">Next Schedule</label>
        <input type="datetime-local" id="next_schedule" name="next_schedule"
            value="{{ old('next_schedule', isset($lead->next_schedule) ? \Carbon\Carbon::parse($lead->next_schedule)->format('Y-m-d\TH:i') : '') }}"
            class="form-control @error('next_schedule') is-invalid @enderror">
        @error('next_schedule')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Set date and time for next follow-up (optional).</div>
    </div>

    <!-- Remarks -->
    <div class="mb-3">
        <label for="remarks" class="form-label">Remarks</label>
        <textarea id="remarks" name="remarks" rows="4" class="form-control @error('remarks') is-invalid @enderror"
            placeholder="Any additional notes...">{{ old('remarks', $lead->remarks ?? '') }}</textarea>
        @error('remarks')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Submit -->
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">{{ isset($lead) ? 'Update' : 'Save' }}</button>
        <a href="{{ route('leads.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
