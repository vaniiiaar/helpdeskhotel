<div class="mb-3">
    <label class="form-label">Assign Staff</label>
    <select name="assigned_to" class="form-select">
        <option value="">-- Pilih Divisi --</option>

        <option value="Engineering" {{ $ticket->assigned_to == 'Engineering' ? 'selected' : '' }}>
            Engineering
        </option>

        <option value="Housekeeping" {{ $ticket->assigned_to == 'Housekeeping' ? 'selected' : '' }}>
            Housekeeping
        </option>

        <option value="IT Support" {{ $ticket->assigned_to == 'IT Support' ? 'selected' : '' }}>
            IT Support
        </option>

        <option value="Security" {{ $ticket->assigned_to == 'Security' ? 'selected' : '' }}>
            Security
        </option>
    </select>
</div>