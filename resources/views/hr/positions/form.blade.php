@if(isset($position) && $position->exists)
    @php $action = route('hr.positions.update', $position); @endphp
    @method('PUT')
@else
    @php $action = route('hr.positions.store'); @endphp
@endif

<form action="{{ $action }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title">Position Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                       value="{{ old('title', $position->title ?? '') }}" required>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="department_id">Department <span class="text-danger">*</span></label>
                <select name="department_id" id="department_id" class="form-control select2 @error('department_id') is-invalid @enderror" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" 
                            {{ old('department_id', $position->department_id ?? '') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="minimum_salary">Minimum Salary</label>
                <input type="number" name="minimum_salary" id="minimum_salary" 
                       class="form-control @error('minimum_salary') is-invalid @enderror" 
                       value="{{ old('minimum_salary', $position->minimum_salary ?? '') }}" min="0" step="0.01">
                @error('minimum_salary')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="maximum_salary">Maximum Salary</label>
                <input type="number" name="maximum_salary" id="maximum_salary" 
                       value="{{ old('maximum_salary', $position->maximum_salary ?? '') }}" min="0" step="0.01">
                @error('maximum_salary')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                  rows="3">{{ old('description', $position->description ?? '') }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    
    <div class="form-group">
        <label for="requirements">Requirements</label>
        <textarea name="requirements" id="requirements" class="form-control @error('requirements') is-invalid @enderror" 
                  rows="3">{{ old('requirements', $position->requirements ?? '') }}</textarea>
        @error('requirements')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    
    <div class="form-group form-check">
        <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
               {{ old('is_active', isset($position) ? $position->is_active : true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
    
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save
        </button>
        <a href="{{ route('hr.positions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</form>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dir: 'rtl',
            width: '100%'
        });
    });
</script>
@endpush
