@extends('layouts.app')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-transparent border-bottom">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="card-title">New Attendance</h3>
                <a href="{{ route('attendances.index') }}" class="btn btn-dark"> <i class="fa-solid fa-chevron-left"></i> Back</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('attendances.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="class_id"> >> Class</label>
                    <select id="class_id" name="class_id" class="form-select @error('class_id') is-invalid @enderror">
                        <option value="">Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">
                                {{ $class->course->name }} - {{ \Carbon\Carbon::parse($class->class_date)->format('Y-m-d') }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        {{ $message }}
                    @enderror
                </div>
    
                <div class="mb-3">
                    <label for="student_id"> >> Student</label>
                    <select id="student_id" name="student_id" class="form-select @error('student_id') is-invalid @enderror">
                        <option value="">Select Student</option>
                    </select>
                    @error('student_id')
                        {{ $message }}
                    @enderror
                </div>
    
                <div class="mb-3">
                    <label for="date"> >> Attendance Date</label>
                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror">
                    @error('date')
                        {{ $message }}
                    @enderror
                </div>
    
                <div class="">
                    <label for="status"> >> Attendance Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="" selected disabled>Choose Status</option>
                        <option value="P">Present</option>
                        <option value="A">Absent</option>
                        <option value="L">Leave</option>
                    </select>
                    @error('status')
                        {{ $message }}
                    @enderror
                </div>
                <button class="btn btn-primary mt-3" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#class_id').on('change', function () {
        var classId = $(this).val();
        if (classId) {
            $.ajax({
                url: '/get-students/' + classId,
                type: 'GET',
                success: function (data) {
                    $('#student_id').empty();
                    $('#student_id').append('<option value="">Select Student</option>');
                    $.each(data, function (key, student) {
                        $('#student_id').append('<option value="' + student.id + '">' + student.name + '</option>');
                    });
                }
            });
        } else {
            $('#student_id').empty();
            $('#student_id').append('<option value="">Select Student</option>');
        }
    });
</script>
@endsection