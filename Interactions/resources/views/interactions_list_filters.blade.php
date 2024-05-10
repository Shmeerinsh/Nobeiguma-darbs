<form data-request="onSetFilters">
    <div class="row">
        <div class="col-md-6 mb-4">
            <label for="contact" class="form-label fw-semibold">Contact</label>
            <select class="form-select" name="filters[contact_id]" id="contact">
                <option value="">- Select -</option>
                @foreach ($interactions as $interaction)
                    @if ($interaction->contact)
                        <option value="{{ $interaction->contact_id }}" {{ isset($filters['contact_id']) && $filters['contact_id'] == $interaction->contact_id ? 'selected' : '' }}>
                            {{ $interaction->contact->first_name }} {{ $interaction->contact->last_name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-4">
            <label for="exampleInputtext" class="form-label fw-semibold">Rating</label>
            <select class="form-select" name="filters[rating]">
                <option value="">- Select -</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ isset($filters['rating']) && $filters['rating'] == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
            </div>
            <div class="col-md-3 mb-4">
                <label for="exampleInputtext" class="form-label fw-semibold">Interaction Type</label>
                <select class="form-select" name="filters[interaction_type]">
                    <option value="">- Select -</option>
                    <option value="in_person" {{ isset($filters['interaction_type']) && $filters['interaction_type'] === 'in_person' ? 'selected' : '' }}>In Person</option>
                    <option value="e-mail" {{ isset($filters['interaction_type']) && $filters['interaction_type'] === 'e-mail' ? 'selected' : '' }}>Email</option>
                    <option value="phone" {{ isset($filters['interaction_type']) && $filters['interaction_type'] === 'phone' ? 'selected' : '' }}>Phone</option>
                </select>
            </div>
            </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="exampleInputtext" class="form-label fw-semibold">Interaction from</label>
                        <input type="datetime-local" class="form-control" name="filters[updated_at][after]" id="updated_at_after" value="{{ isset($filters['updated_at']['after']) ? $filters['updated_at']['after'] : }}" >
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="exampleInputtext" class="form-label fw-semibold">Interaction to</label>
                        <input type="datetime-local" class="form-control" name="filters[created_at][before]" id="created_at_before" value="{{ isset($filters['created_at']['before']) ? $filters['created_at']['before'] : }}">
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-6 text-end pe-1">
        <button type="reset" class="btn mb-1 waves-effect waves-light bg-secondary-subtle text-secondary">
         <i class="ti ti-reload"></i>
            Reset
        </button>
    </div>
        <div class="col-6 text-start ps-1">
            <button type="submit" class="btn mb-1 waves-effect waves-light btn-primary">
                <i class="ti ti-adjustments"></i>
                    Filter
            </button>
        </div>
    </div>
</form>
