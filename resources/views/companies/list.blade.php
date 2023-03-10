@extends('layouts.master')

@section("page_title")
    Company
@endsection

@section("content_header")
    Company
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Company List ({{ $companies->count() }})</h5>
                    <div class="heading-elements">
                        @can('company-create')
                        <a href="{{route('companies.create')}}" class="btn btn-danger mr-1 mb-1">
                            <i class="bx bx-plus-circle"></i> Create New
                        </a>
                        @endcan
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Bin</th>
                                    <th>Phone Number</th>
                                    <th>Website</th>
                                    <th>Logo</th>
                                    <th>Cost Center</th>
                                    <th width="10%" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @forelse($companies as $company)
                                    <tr>

                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->address }}</td>
                                        <td>{{ $company->bin }}</td>
                                        <td>{{ $company->phone_numbers }}</td>
                                        <td>{{ $company->website }}</td>
                                        <td>
                                            <img
                                                src="{{ $company->logo !== null ? asset(''.$company->logo ) : '/assets/images/default-avatar-male-alt.png' }}"
                                                class=" rounded" alt="Company logo" width="80" height="80">
                                        </td>
                                        <td>

                                            @foreach($company->costCenters as $costCenter)
                                                <a href="cost-center/{{$costCenter->id}}"
                                                   class="badge badge-secondary mb-1"> {{ $costCenter->name }}</a>

                                            @endforeach

                                        </td>

                                        <td style="width:auto;white-space: nowrap;">
                                            @can('company-edit')
                                            <a href="{{ route('companies.edit', $company->id) }}"
                                               class="btn btn-icon btn-success glow mr-1 mb-1"><i
                                                    class="bx bx-edit-alt"></i></a>
                                            @endcan
                                            @can('company-delete')
                                            <a href="#"
                                               class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                               data-method="DELETE"
                                               data-action="{{ route('companies.destroy', $company) }}"
                                               data-message="Are you sure, You want to remove this Company?"><i
                                                    class="bx bx-trash-alt"></i></a>
                                            @endcan

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Records</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6">
                                        @if(!empty($companies->pagination_summary))
                                            <span
                                                class="label label-primary">{{ $companies->pagination_summary }}</span>
                                        @endif
                                    </td>
                                    <td colspan="2">
                                        <div class="pull-right">{{ $companies->links() }}</div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
