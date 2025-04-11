<div class="container">
    <div class="row mb-2">
        <div class="col-2 fw-bold text-end">Name:</div>
        <div class="col-10">{{ $student->name ?? 'N/A' }}</div>
    </div>
  
    <div class="row mb-2">
        <div class="col-2 fw-bold text-end">Email:</div>
        <div class="col-10">{{ $student->email ?? 'N/A' }}</div>
    </div>
    
    <div class="row mb-2">
        <div class="col-2 fw-bold text-end">NRC:</div>
        <div class="col-10">{{ $student->nrc ?? 'N/A' }}</div>
    </div>
    
    <div class="row mb-2">
        <div class="col-2 fw-bold text-end">Phone:</div>
        <div class="col-10">{{ $student->phone ?? 'N/A' }}</div>
    </div>
    
    <div class="row mb-2">
        <div class="col-2 fw-bold text-end">Gender:</div>
        <div class="col-10">{{ $student->gender ?? 'N/A' }}</div>
    </div>
    
    <div class="row mb-2">
        <div class="col-2 fw-bold text-end">DOB:</div>
        <div class="col-10">{{ $student->dob ?? 'N/A' }}</div>
    </div>
    
    <div class="row mb-2">
        <div class="col-2 fw-bold text-end">NRC:</div>
        <div class="col-10">{{ $student->nrc ?? 'N/A' }}</div>
    </div>
    @if($student->classes->count())
    <p class="fw-bold"> Enrolled Classes: </p>
    <ul style="list-style-type: number">
        @foreach($student->classes as $class)
            <li> {{ $class->course->name }} - {{ $class->start_date->format('Y-m-d') }} </li>
        @endforeach
    </ul>
    @else
        <p>No enrolled classes found.</p>
    @endif
</div>