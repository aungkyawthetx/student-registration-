<div class="container">
  <div class="row mb-2">
      <div class="col-4 fw-bold text-end">Course Name:</div>
      <div class="col-8">{{ $class->course->name ?? 'N/A' }}</div>
  </div>

  <div class="row mb-2">
      <div class="col-4 fw-bold text-end">Fees:</div>
      <div class="col-8">{{ $class->course->fees ?? 'N/A' }}</div>
  </div>
</div>

