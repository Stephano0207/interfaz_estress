<!-- resources/views/stress_prediction/form.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Predict Student Stress Level</h2>

    @if(session('prediction'))
    <div class="alert alert-info mb-4">
        <h4>Prediction Result:</h4>
        <p class="mb-1"><strong>Stress Level:</strong> {{ session('prediction') }}</p>
    </div>
    @endif

    <form method="POST" action="{{ route('predict.stress') }}">
        @csrf

        <div class="form-group">
            <label for="study_hours">Study Hours Per Day</label>
            <input type="number" step="0.1" class="form-control" id="study_hours" name="study_hours"
                   value="{{ old('study_hours') }}" min="0" max="24" >
            @error('study_hours')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="extracurricular_hours">Extracurricular Hours Per Day</label>
            <input type="number" step="0.1" class="form-control" id="extracurricular_hours" name="extracurricular_hours"
                   value="{{ old('extracurricular_hours') }}" min="0" max="24" >
            @error('extracurricular_hours')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="sleep_hours">Sleep Hours Per Day</label>
            <input type="number" step="0.1" class="form-control" id="sleep_hours" name="sleep_hours"
                   value="{{ old('sleep_hours') }}" min="0" max="24" >
            @error('sleep_hours')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="social_hours">Social Hours Per Day</label>
            <input type="number" step="0.1" class="form-control" id="social_hours" name="social_hours"
                   value="{{ old('social_hours') }}" min="0" max="24" >
            @error('social_hours')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="physical_activity_hours">Physical Activity Hours Per Day</label>
            <input type="number" step="0.1" class="form-control" id="physical_activity_hours" name="physical_activity_hours"
                   value="{{ old('physical_activity_hours') }}" min="0" max="24" >
            @error('physical_activity_hours')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="gpa">GPA</label>
            <input type="number" step="0.01" class="form-control" id="gpa" name="gpa"
                   value="{{ old('gpa') }}" min="0" max="20" >
            @error('gpa')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Predict Stress Level</button>
    </form>
</div>
@endsection
