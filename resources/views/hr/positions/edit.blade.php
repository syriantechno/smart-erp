@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">تعديل الوظيفة: {{ $position->title }}</h4>
                </div>
                <div class="card-body">
                    @include('hr.positions.form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
