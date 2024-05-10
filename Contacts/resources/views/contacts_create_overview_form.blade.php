<div class="row offset-md-3 col-md-12">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h5 class="md-3">Basic information</h5>
                    </div>
                </div>
                <form data-request="onAction">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="exampleInputtext" class="form-label fw-semibold">First name</label>
                            <input type="text" class="form-control" name="first_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contact" class="form-label">Last name</label>
                            <input type="text" class="form-control" name="last_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="phone">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="created_at" class="form-label">E-mail</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center m-3">
                            <button type="submit" data-request="onAction" data-request-data="action: 'create_contact'" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i>
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>