<div class="table-responsive">
    <table class="table table-nowrap table-hover table-align-middle">
        <thead class="thead-light">
            <tr>
                <th class="align-middle" style="width: 30px">
                    <input type="checkbox" class="form-check-input" id="list-select-all">
                </th>
                <th>{{ 'Title' }}</th>
                <th>{{ 'Status' }}</th>
                <th>{{ 'Phone' }}</th>
                <th>{{ 'Email' }}</th>
                <th class="text-end">{{ 'Action' }}</th>
            </tr>
        </thead>
        <tbody id="filtered-data">
            @foreach ($listItems as $listItem)
                <tr id="list-row-{{ $listItem->id }}" data-request-data="listItem: {{ $listItem->id }}">
                    <td class="align-middle">
                        <input type="checkbox" class="form-check-input" id="check-{{ $listItem->id }}">
                    </td>
                    <td class="align-middle">
                        <a href="/clients/profile/{{ $listItem->id }}">
                            <div class="d-flex align-items-center">
                                <div class="p-6 bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-address-book text-primary fs-7"></i>
                                </div>
                                <div class="">
                                    <div class="user-meta-info">
                                        <h6 class="user-name mb-0" data-name="{{ $listItem->title }}">{{ $listItem->first_name }} {{ $listItem->last_name }}</h6>
                                        <span class="user-work fs-2" data-occupation="">{{ $listItem->address_full }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td class="align-middle text-center">
                        <span class="py-2 text-primary fw-semibold fs-2 d-inline-flex align-items-center justify-content-center gap-1">
                            <i class="ti ti-check fs-4" style="margin-right: 20px;"></i>{{ $listItem->status }}
                        </span>
                    </td>
                    <td class="align-middle">
                        <span class="round-8 text-bg-info rounded-circle d-inline-block me-1"></span>{{ $listItem->phone }}
                    </td>
                    <td class="align-middle">
                        <span class="round-8 text-bg-success rounded-circle d-inline-block me-1"></span>{{ $listItem->email }}
                    </td>
                    <td class="text-end align-middle">
                        <a class="btn bg-primary-subtle btn-sm" data-bs-toggle="tooltip" title="{{ $listItem->website }}" href="{{ $listItem->website }}" target="_blank">
                            <i class="ti ti-link"></i>
                        </a>
                        <a href="/clients/profile/{{ $listItem->id }}" class="btn bg-primary-subtle btn-sm" data-bs-toggle="tooltip" title="Open profile">
                            <i class="ti ti-briefcase"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
