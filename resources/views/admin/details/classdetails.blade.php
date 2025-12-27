<div class="container">
  <div class="row mb-2">
      <div class="col-4 fw-bold text-end">Course:</div>
      <div class="col-8">{{ $class->course->name ?? 'N/A' }}</div>
  </div>

  <div class="row mb-2">
      <div class="col-4 fw-bold text-end">Room:</div>
      <div class="col-8">{{ $class->room->name ?? 'Online / TBD' }}</div>
  </div>

  <div class="row mb-2">
      <div class="col-4 fw-bold text-end">Start Date:</div>
      <div class="col-8">{{ $class->start_date ?? 'N/A' }}</div>
  </div>

  <div class="row mb-2">
      <div class="col-4 fw-bold text-end">End Date:</div>
      <div class="col-8">{{ $class->end_date ?? 'N/A' }}</div>
  </div>

  <div class="row mb-2">
      <div class="col-4 fw-bold text-end">Time:</div>
      <div class="col-8">{{ $class->time ?? 'N/A' }}</div>
  </div>

  <div class="row mb-2">
      <div class="col-4 fw-bold text-end">Total Students:</div>
      <div class="col-8">{{ $class->students->count() }}</div>
  </div>
</div>
