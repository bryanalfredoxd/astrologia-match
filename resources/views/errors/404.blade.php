@extends('layouts.app')

@section('title', 'Error cósmico')

<link rel="stylesheet" href="{{ asset('css/404.css') }}">

@section('content')
<section class="cosmic-error-section d-flex align-items-center justify-content-center py-5">
    <div class="cosmic-error-container" data-aos="zoom-in">
        <div class="cosmic-error-number">404</div>
        <i class="bi bi-meteor comet-icon"></i>
        <h1 class="cosmic-error-title">¡Error cósmico detectado!</h1>
        <p class="cosmic-error-message">
            La constelación que buscas se ha perdido en el cosmos.

        </p>
        <a href="{{ url('/') }}" class="btn cosmic-error-btn">
            <i class="bi bi-rocket me-2"></i> Regresar a la base
        </a>
        
    </div>
</section>
@endsection