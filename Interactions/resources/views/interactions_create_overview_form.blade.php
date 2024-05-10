<style>
    * {
        margin: 0;
        padding: 0;
    }

    .rate-container {
        margin-top: -10px; /* Adjust the margin as needed */
    }

    .rate {
        display: inline-block;
        height: 46px;
        padding: 0 10px;
    }

    .rate:not(:checked) > input {
        position: absolute;
        top: -9999px;
    }

    .rate:not(:checked) > label {
        float: right;
        width: 1em;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 30px;
        margin-top: -9px;
        color: transparent; /* Hide the text content */
    }

    .rate:not(:checked) > label img {
        opacity: 0.5; /* Adjust the opacity for the non-selected stars */
    }

    .rate > input:checked ~ label img {
        opacity: 1; /* Full opacity for the selected star */
    }

    .rate:not(:checked) > label:hover img,
    .rate:not(:checked) > label:hover ~ label img {
        opacity: 1; /* Full opacity on hover */
    }
</style>
    <div class="row offset-md-3 col-md-12">
        {{-- Basic information --}}
        <div class="col-md-12">
            <h5 class="mb-3">Basic information</h5>
        </div>
        <div class="col-md-12">
            <form data-request="onAction">
                <!-- First Row -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="exampleInputtext" class="form-label fw-semibold">Client</label>
                        <select class="form-select" name="client_id" id="client">
                            <option value="">- Select -</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->title }}</option>                 
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact" class="form-label">Contact:</label>
                        <select class="form-select" name="contact_id" id="contact" disabled>
                            <option value="">- Select -</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Interaction Type:</label>
                        <select class="form-select mr-sm-2" name="interaction_type" id="inlineFormCustomSelect">
                            <option value=""></option>
                            <option value="phone">Phone</option>
                            <option value="e-mail">E-mail</option>
                            <option value="in_person">In Person</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="created_at" class="form-label">Date:</label>
                        <input type="datetime-local" class="form-control" name="created_at" value="time">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="type" class="form-label">Notes:</label>
                        <textarea name="notes" class="form-control" rows="4" maxlength="1000"></textarea>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="type" class="form-label">Rating:</label>
                                <div class="rate-container">
                                    <div class="rate">
                                        <input type="radio" id="star5" name="rating" value="5" />
                                        <label for="star5" title="gorgeous">
                                            <img alt="5" src="/assets/images/rating/star-on.png" title="gorgeous">
                                        </label>

                                        <input type="radio" id="star4" name="rating" value="4" />
                                        <label for="star4" title="good">
                                            <img alt="4" src="/assets/images/rating/star-on.png" title="good">
                                        </label>

                                        <input type="radio" id="star3" name="rating" value="3" />
                                        <label for="star3" title="regular">
                                            <img alt="3" src="/assets/images/rating/star-on.png" title="regular">
                                        </label>

                                        <input type="radio" id="star2" name="rating" value="2" />
                                        <label for="star2" title="poor">
                                            <img alt="2" src="/assets/images/rating/star-on.png" title="poor">
                                        </label>

                                        <input type="radio" id="star1" name="rating" value="1" />
                                        <label for="star1" title="bad">
                                            <img alt="1" src="/assets/images/rating/star-on.png" title="bad">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center m-3">
                        <button type="submit" data-request="onAction" data-request-data="action: 'create_interaction'"  class="btn btn-primary">
                            <i class="ti ti-check me-1"></i>
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $(document).ready(function() {
        $('#client').change(function() {
            var clientId = $(this).val();
            if (clientId !== "") {
                $('#contact').prop('disabled', false);
                $.request('onAction', {
                    data: {
                        action: 'get_client_contacts',
                        client_id: clientId
                    },
                    success: function(response) {
                        $('#contact').empty();
                        // Add default option
                        $('#contact').append('<option value="">- Select -</option>');
                        console.log(response);
                        $.each(response, function(index, contact) {
                            $('#contact').append('<option value="' + contact.id + '">' + contact.first_name + ' ' + contact.last_name + '</option>');
                        });
                    }
                });
            } else {
                $('#contact').empty();
                $('#contact').append('<option value="">- Select -</option>');
            }
        });

        // Handle contact selection
        $('#contact').change(function() {
            var contactId = $(this).val();
            if (contactId) {
                $.request('onAction', {
                    data: {
                        action: 'get_contact_details',
                        contact_id: contactId
                    },
                    success: function(response) {
                        $('#first_name').val(response.first_name);
                        $('#last_name').val(response.last_name);

                        // Update the hidden inputs with the contact's details
                        $('#contact_first_name').val(response.first_name);
                        $('#contact_last_name').val(response.last_name);
                    }
                });
            }
        });

        // Handle form submission
        $('[data-request="onAction"]').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serializeArray();
            $.request('onAction', {
                data: formData,
                success: function(response) {
                    // Handle success response
                    console.log(response);
                }
            });
        });
    });
});
</script>
