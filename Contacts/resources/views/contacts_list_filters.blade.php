<form data-request="onSetFilters">
    <div class="row">
        <div class="col-md-6 mb-4">
            <label for="exampleInputtext" class="form-label fw-semibold">First Name</label>
            <input type="text" class="form-control" name="filters[first_name][like]" value="{{ isset($filters['first_name']['like']) ? $filters['first_name']['like'] : '' }}">           
        </div>
        <div class="col-md-6 mb-4">
            <label for="exampleInputtext" class="form-label fw-semibold">Last Name</label>
            <input type="text" class="form-control" name="filters[last_name][like]" value="{{ isset($filters['last_name']['like']) ? $filters['last_name']['like'] : '' }}">           
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <label for="exampleInputtext" class="form-label fw-semibold">Phone</label>
            <input type="text" class="form-control" name="filters[phone][like]" value="{{ isset($filters['phone']['like']) ? $filters['phone']['like'] : '' }}">           
        </div>
        <div class="col-md-6 mb-4">
            <label for="exampleInputtext" class="form-label fw-semibold">E-mail</label>
            <input type="text" class="form-control" name="filters[email][like]" value="{{ isset($filters['email']['like']) ? $filters['email']['like'] : '' }}">           
        </div>
    </div>
    <div class="row">
    <div class="col-6 text-end pe-1">
        <button type="reset" class="btn mb-1 waves-effect waves-light bg-secondary-subtle text-secondary" data-request="onUnsetFilters">
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