{{-- resources/views/payment/cancel.blade.php --}}
@extends('layouts.app')

@section('title', 'Pago Cancelado - Jeff Academy')

@section('content')
<section style="margin-top:100px; padding:40px 0; background:#f8f9fa; min-height:60vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg border-0" style="border-radius:16px;">
          <div class="card-body text-center p-5">
            <div class="mb-4">
              <div style="width:80px;height:80px;background:#dc3545;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                <i class="fas fa-times fa-2x text-white"></i>
              </div>
              <h2 class="h3 mb-3" style="color:#dc3545;">Pago Cancelado</h2>
              <p class="text-muted mb-4">El proceso de pago ha sido cancelado. No se ha realizado ningún cargo.</p>
            </div>
            
            <div class="d-grid gap-2">
              <a href="{{ route('registro.elegir-plan') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Volver a Planes
              </a>
              <a href="{{ url('/') }}" class="btn btn-outline-primary">
                <i class="fas fa-home me-2"></i>Ir al Inicio
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection