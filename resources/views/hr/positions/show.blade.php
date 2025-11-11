@extends('layouts.app')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Position Details: {{ $position->title }}</h4>
                    <div>
                        <a href="{{ route('hr.positions.edit', $position) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('hr.positions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Position Title:</th>
                                    <td>{{ $position->title }}</td>
                                </tr>
                                <tr>
                                    <th>Department:</th>
                                    <td>{{ $position->department->name ?? 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <th>Salary Range:</th>
                                    <td>
                                        @if($position->minimum_salary && $position->maximum_salary)
                                            {{ number_format($position->minimum_salary) }} - {{ number_format($position->maximum_salary) }} SAR
                                        @else
                                            Not specified
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge {{ $position->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $position->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Employees in this Position</h5>
                                </div>
                                <div class="card-body p-0">
                                    @if($position->employees->count() > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach($position->employees as $employee)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $employee->full_name }}
                                                    <a href="{{ route('hr.employees.show', $employee) }}" class="btn btn-sm btn-link">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="p-3 text-center text-muted">
                                            No employees assigned to this position
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($position->description)
                        <div class="mt-4">
                            <h5>Description</h5>
                            <div class="p-3 bg-light rounded">
                                {!! nl2br(e($position->description)) !!}
                            </div>
                        </div>
                    @endif
{{ ... }}
                    @endif
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">
                            Created at: {{ $position->created_at->format('Y/m/d') }}
                        </span>
                        <span class="text-muted">
                            Last updated: {{ $position->updated_at->format('Y/m/d') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
{{ ... }}
</div>
@endsection
