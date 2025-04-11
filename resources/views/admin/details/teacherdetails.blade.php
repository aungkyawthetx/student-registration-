<div class="container">
  <div class="row mb-2">
      <div class="col-1 fw-bold text-end">Name:</div>
      <div class="col-11">{{ $teacher->name ?? 'N/A' }}</div>
  </div>
  <div class="row mb-2">
      <div class="col-1 fw-bold text-end">Email:</div>
      <div class="col-11">{{ $teacher->email ?? 'N/A' }}</div>
  </div>
  <div class="row mb-2">
      <div class="col-1 fw-bold text-end">Phone:</div>
      <div class="col-11">{{ $teacher->phone ?? 'N/A' }}</div>
  </div>
</div>