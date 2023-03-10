@extends('layouts.master')

@section('page_title')
    Vendor
@endsection

@section('content_header')
    Vendor
@endsection

@section('content')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Vendor: {{ strtoupper($vendor->vendor_code) }}</h5>
                        <div class="heading-elements">

                            <a href="{{ route('vendors.index') }}" class="btn btn-light-secondary mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>

                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                        <tr>
                                            <td>Name :</td>
                                            <td>{{ $vendor->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>{{ $vendor->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>Off. Phone</td>
                                            <td>{{ $vendor->office_phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Off. Email</td>
                                            <td>{{ $vendor->office_email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>{{ $vendor->status ? 'Active' : 'Inactive' }}</td>
                                        </tr>
                                        @if ($vendor->bin)
                                            <tr>
                                                <td>BIN</td>
                                                <td>{{ $vendor->bin }}</td>
                                            </tr>
                                        @endif
                                        @if ($vendor->tin)
                                            <tr>
                                                <td>TIN</td>
                                                <td>{{ $vendor->tin }}</td>
                                            </tr>
                                        @endif
                                        @if ($vendor->trade_license)
                                            <tr>
                                                <td>Trade Licence</td>
                                                <td>{{ $vendor->trade_license }}</td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>

                                        @if ($vendor->bank_account_name)
                                            <tr>
                                                <td>Bank Account Name</td>
                                                <td>{{ $vendor->bank_account_name }}</td>
                                            </tr>
                                        @endif
                                        @if ($vendor->bank_account_number)
                                            <tr>
                                                <td>Account Number</td>
                                                <td>{{ $vendor->bank_account_number }}</td>
                                            </tr>
                                        @endif
                                        @if ($vendor->bank_routing_number)
                                            <tr>
                                                <td>Routing Number</td>
                                                <td>{{ $vendor->bank_routing_number }}</td>
                                            </tr>
                                        @endif
                                        @if ($vendor->bank_name)
                                            <tr>
                                                <td>Bank Name</td>
                                                <td>{{ $vendor->bank_name }}</td>
                                            </tr>
                                        @endif
                                        @if ($vendor->bank_branch)
                                            <tr>
                                                <td>Branch Name</td>
                                                <td>{{ $vendor->bank_branch }}</td>
                                            </tr>
                                        @endif
                                        {{-- Record info. --}}
                                        @if ($vendor->created_by)
                                            <tr>
                                                <td>Created By</td>
                                                <td>{{ $vendor->createdBy ? $vendor->createdBy->username : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Created At</td>
                                                <td>{{ \App\Helpers\Parser::parseDate($vendor->created_at) }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($vendor->updated_by)
                                            <tr>
                                                <td>Updated By</td>
                                                <td>{{ $vendor->updatedBy ? $vendor->updatedBy->name : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Updated At</td>
                                                <td>{{ \App\Helpers\Parser::parseDate($vendor->updated_at) }}
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                @if ($vendor->has('contacts'))
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <div class="d-flex">
                                                <div class="mr-auto p-2">
                                                    <h5> Contracts List </h5>
                                                </div>
                                                <div class="p-2">
                                                    <a href="{{ route('contacts.create', ['id' => $vendor->id, 'type' => 'Vendor']) }}"
                                                       class="btn btn-icon btn-warning glow mr-1 mb-1"><i
                                                            class="bx bx-user-plus"></i> Create Contract</a>
                                                </div>
                                            </div>
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Sl.</th>
                                                    <th>Name</th>
                                                    <th>Number</th>
                                                    <th>Email</th>
                                                    <th>Position/Role</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($vendor->contacts as $contact)
                                                    <tr>
                                                        <td class="text-center">{{ $i++ }}</td>
                                                        <td class="text-center">{{ $contact->contact_person ?? '' }}</td>
                                                        <td class="text-center">{{ $contact->contact_phone ?? '' }}</td>
                                                        <td class="text-center">{{ $contact->contact_email  }}</td>
                                                        <td class="text-center">{{ $contact->position ?? '' }}</td>
                                                        <td class="text-center">{{ $contact->is_default ? 'Default' : 'Secondary' }}</td>
                                                        <td style="width:auto;white-space: nowrap;">
                                                            @can('contact-edit')
                                                                <a href="{{ route('contacts.edit', $contact->id) }}"
                                                                   class="btn btn-icon btn-success glow mr-1 mb-1"><i
                                                                        class="bx bx-edit-alt"></i></a>
                                                            @endcan
                                                            @can('contact-delete')
                                                                <a href="#"
                                                                   class="btn btn-icon btn-danger alert-dialog glow mr-1 mb-1"
                                                                   data-id="{{ $contact->id }}"
                                                                   data-action="{{ route('contacts.destroy', $contact) }}"
                                                                   data-method="DELETE"
                                                                   data-message="Are you sure, You want to remove this Contact?"><i
                                                                        class="bx bx-trash-alt"></i></a>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
