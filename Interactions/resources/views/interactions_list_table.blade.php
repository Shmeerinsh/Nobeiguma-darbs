<div class="table-responsive mt-3">
    <table class="table table-nowrap table-hover table-align-middle">
        <thead class="thead-light">
            <tr>
                <th style="width: 30%;">{{ 'Contact' }}</th>
                <th style="width: 5%;">{{ 'Type' }}</th>
                <th style="width: 15%;">{{ 'Rating' }}</th>
                <th style="width: 20%;">{{ 'Notes' }}</th>
                <th style="width: 13%;">{{ 'Date' }}</th>
                <th class="text-end" style="width: 12%">{{ 'Action' }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listItems as $interaction) 
                <tr>
                    <td class="align-middle"> 
                        <a href="/clients/profile/{{ $interaction->id }}">
                            <div class="d-flex align-items-center">
                                <div class="p-6 bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-transform text-primary fs-4"></i>
                                </div>
                                <div class="">
                                    <div class="user-meta-info">
                                        <h6 class="user-name mb-0" data-name="{{ $interaction->contact_id }}">
                                            @isset($interaction->contact)
                                                {{ $interaction->contact->first_name }} {{ $interaction->contact->last_name }}
                                            @endisset
                                        </h6>
                                        <div style="font-size: 12px; color: #888;">
                                            @isset($interaction->client)
                                            {{ $interaction->client->title }}
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td class="align-middle">
                    @if(isset($interactionType[$interaction->interaction_type]))
                    <span class="badge bg-{{ $interactionType[$interaction->interaction_type]['color'] }}-subtle rounded-3 py-2 text-{{ $interactionType[$interaction->interaction_type]['color'] }} fw-semibold fs-2 d-inline-flex align-items-center gap-1">
                        <i class="{{ $interactionType[$interaction->interaction_type]['icon'] }}"></i>
                        {{ $interactionType[$interaction->interaction_type]['title'] }}
                    </span>
                    @else
                    @endif
                    </td>
                    <td class="align-middle">
                        <div id="score-rating" style="cursor: pointer; white-space: nowrap;">
                            @if($interaction->rating == 5)
                                <img alt="1" src="/assets/images/rating/star-on.png" title="bad">
                                <img alt="2" src="/assets/images/rating/star-on.png" title="poor">
                                <img alt="3" src="/assets/images/rating/star-on.png" title="regular">
                                <img alt="4" src="/assets/images/rating/star-on.png" title="good">
                                <img alt="5" src="/assets/images/rating/star-on.png" title="gorgeous">
                            @elseif($interaction->rating == 4)
                                <img alt="1" src="/assets/images/rating/star-on.png" title="bad">
                                <img alt="2" src="/assets/images/rating/star-on.png" title="poor">
                                <img alt="3" src="/assets/images/rating/star-on.png" title="regular">
                                <img alt="4" src="/assets/images/rating/star-on.png" title="good">
                            @elseif($interaction->rating == 3)
                                <img alt="1" src="/assets/images/rating/star-on.png" title="bad">
                                <img alt="2" src="/assets/images/rating/star-on.png" title="poor">
                                <img alt="3" src="/assets/images/rating/star-on.png" title="regular">
                            @elseif($interaction->rating == 2)
                                <img alt="1" src="/assets/images/rating/star-on.png" title="bad">
                                <img alt="2" src="/assets/images/rating/star-on.png" title="poor">
                            @elseif($interaction->rating == 1)
                                <img alt="1" src="/assets/images/rating/star-on.png" title="bad">
                            @endif
                            <input name="score" type="hidden" value="{{ $interaction->rating }}">
                        </div>
                    </td>
                    <td class="align-middle">
                            <div style="padding: 5px;">
                                {{ strlen($interaction->notes) > 50 ? substr($interaction->notes, 0, 50) . '...' : $interaction->notes }}
                            </div>
                    </td>
                    <td class="align-middle">{{ $interaction->created_at}}</td>
                    <td class="text-end align-middle">
                        <a class="btn bg-secondary-subtle" data-bs-toggle="tooltip" title="{{ $interaction->website }}" href="/interactions"  target="_blank">
                            <i class="ti ti-link"></i>
                        </a>
                        <a href="/clients/profile/{{ $interaction->id }}" class="btn bg-primary-subtle" data-bs-toggle="tooltip" title="Open profile">
                            <i class="ti ti-briefcase"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


