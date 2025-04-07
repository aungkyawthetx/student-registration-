<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  {{-- bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  {{-- bootstrap icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
  {{-- fontawesome  --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
@extends('components.dark-mode')
<body data-bs-theme="light" style="overflow-x: hidden;">
    <div class="img-container">
    <img src="/images/auth-bg.jpg" alt="auth-bg" id="auth-bg" class="img-fluid" style="width:100%; height: 100vh; object-fit: cover;">
</div>
    <div class="container position-absolute top-50 start-50 translate-middle" style="z-index: 1;">
        <div class="card m-auto " style="max-width: 700px; border-radius: 10px;">
            <div class="card-header text-center" style="border-radius: 10px 10px 0 0;">
                <h4 class="mb-0">@yield('auth-title')</h4>
            </div>
            <div class="card-body p-4">
                @yield('content')
            </div>
        </div>
    </div>
{{-- bootstrap js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
