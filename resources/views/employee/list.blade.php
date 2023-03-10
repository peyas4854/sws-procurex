@extends('layouts.master')

@section('page_title')
    Employee
@endsection

@section('content_header')
    Employee
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Employee List ({{ $employees->count() }})</h5>
                    <div class="heading-elements">
                        @can('employee-create')
                            @include('base-component.create-button', [
                                'url' => route('employee.create'),
                                'text' => 'Create New',
                            ])
                        @endcan
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {!! Form::open(["url" => url('employee'),'method' => 'get']) !!}
                        <div class="row">
                            <div class="col">
                                <label for="department_id">Search  </label>
                                <input type="text" class="form-control" placeholder="Search employee name or code"
                                       name="search" value="{{ $request->search }}" style="width: 300px">
                            </div>
                            <div class="col">
                                <label for="department_id">Department  </label>
                                {!! Form::select('department_id',$department,$request->department_id,['class'=>'form-control select2','placeholder'=>'-- Select department--']) !!}

                            </div>
                            <div class="col">
                                <label for="department_id">Designation  </label>
                                {!! Form::select('designation_id',$designation,$request->designation_id,['class'=>'form-control select2','placeholder'=>'-- Select designation--']) !!}

                            </div>
                            <div class="col">
                                <label for="cost_center_id">Cost Center  </label>
                                {!! Form::select('cost_center_id',$costCenter,$request->cost_center_id,['class'=>'form-control select2','placeholder'=>'-- Select cost center--']) !!}

                            </div>

                            <div class="col">
                                <label for="">  </label>
                                <button class="btn btn-primary btn-block" type="submit">Search</button>
                            </div>
                            <div class="col">
                                <label for="">  </label>
                                <a href="{{ url('employee') }}" class="btn btn-info btn-block" type="submit">Refresh</a>
                            </div>
                        </div>
                        {!! Form::close() !!}

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        <a href class="" data-toggle="tooltip" data-placement="top" title=""
                                           data-original-title="Employee Id">
                                            Id
                                        </a>
                                    </th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Cost Center</th>
                                    <th>Created At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->code }}</td>
                                        <td>{{ $employee->full_name }}</td>
                                        <td>{{ $employee->department->name ?? '' }}
                                            ({{ $employee->department_employee_count }})
                                        </td>
                                        <td>{{ $employee->designation->name ?? '' }}
                                        </td>
                                        <td>{{ $employee->costCenter->name ?? '' }}
                                            ({{ $employee->cost_center_employee_count }})
                                        </td>
                                        <td>{{ \App\Helpers\Parser::parseDate($employee->created_at) }}</td>
                                        <td style="width:auto;white-space: nowrap;">
                                            @can('employee-view')
                                                <a href="{{ route('employee.show', $employee->id) }}"
                                                   class="btn btn-icon btn-info glow mr-1 mb-1">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                            @endcan
                                            @can('employee-edit')
                                                <a href="{{ route('employee.edit', $employee->id) }}"
                                                   class="btn btn-icon btn-success glow mr-1 mb-1"><i
                                                        class="bx bx-edit-alt"></i></a>
                                            @endcan
                                            @can('employee-delete')
                                                <a href="#"
                                                   class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                   data-method="DELETE"
                                                   data-action="{{ route('employee.destroy', $employee) }}"
                                                   data-message="Are you sure, You want to remove this Employee?"><i
                                                        class="bx bx-trash-alt"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">No Records</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3">
                                        @if (!empty($employees->pagination_summary))
                                            <span
                                                class="label label-primary">{{ $employees->pagination_summary }}</span>
                                        @endif
                                    </td>
                                    <td colspan="4">
                                        {{-- <div class="pull-right">{{ $employees->links() }}</div> --}}
                                        <div class="pull-right">{{ $employees->onEachSide(5)->links() }}</div>
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
