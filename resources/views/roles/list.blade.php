@extends('layouts.master')

@section('page_title')
    Role
@endsection

@section('content_header')
    Role
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Role List ({{ $roles->total() }})</h5>
                    <div class="heading-elements">
                        @can('list', Spatie\Permission\Models\Role::class)
                            <a href="{{ route('roles.index') }}" class="btn btn-primary mr-1 mb-1">
                                <i class="bx bx-list-ul"></i> Role List
                            </a>
                        @endcan
                        @can('role-create')
                            @include('base-component.create-button', [
                                'url' => route('roles.create'),
                                'text' => 'Add New Role',
                            ])
                        @endcan
                        @can('create', \App\User::class)
                            <a href="{{ url('users/create') }}" class="btn btn-dark mr-1 mb-1">
                                <i class="bx bx-user-plus"></i> Add New User
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-gray-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Name</th>
                                        <th width="20%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td class="text-center">
                                                @can('role-view')
                                                    <a href="{{ route('roles.show', $role) }}"
                                                        class="btn btn-icon btn-info btn-sm glow mr-1 mb-1"><i
                                                            class="bx bx-show"></i></a>
                                                @endcan
                                                @can('role-edit')
                                                    <a href="{{ route('roles.edit', $role) }}"
                                                        class="btn btn-icon btn-dark btn-sm glow mr-1 mb-1"><i
                                                            class="bx bx-edit-alt"></i></a>
                                                @endcan
                                                @can('role-delete')
                                                    <a href="#"
                                                        class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                        data-method="DELETE" data-action="{{ route('roles.destroy', $role) }}"
                                                        data-message="Are you sure, You want to remove this role?"><i
                                                            class="bx bx-trash-alt"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="3">No records found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            @if (!empty($roles->pagination_summary))
                                                <span class="label label-primary">{{ $roles->pagination_summary }}</span>
                                            @endif
                                        </td>
                                        <td colspan="2">
                                            <div class="pull-right">{{ $roles->links() }}</div>
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
