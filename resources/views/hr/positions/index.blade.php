@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Positions Management</h4>
                    <a href="{{ route('hr.positions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Position
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Position Title</th>
                                    <th>Department</th>
                                    <th>Employees</th>
                                    <th>Salary Range</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            <tbody>
                                @forelse($positions as $position)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $position->title }}</td>
                                        <td>{{ $position->department->name ?? 'Not Assigned' }}</td>
                                        <td>{{ $position->employees_count ?? 0 }}</td>
                                        <td>
                                            @if($position->minimum_salary && $position->maximum_salary)
                                                {{ number_format($position->minimum_salary) }} - {{ number_format($position->maximum_salary) }}
                                            @else
                                                Not Specified
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $position->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $position->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('hr.positions.show', $position) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('hr.positions.edit', $position) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('hr.positions.destroy', $position) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this position?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No positions found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $positions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
