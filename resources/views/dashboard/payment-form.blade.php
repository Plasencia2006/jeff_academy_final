@extends('layouts.app')

@section('title', 'Procesar Pago - Jeff Academy')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-success text-white py-4">
                    <h2 class="mb-0 text-center">
                        <i class="fas fa-lock me-2"></i>Procesar Pago
                    </h2>
                </div>
                
                <div class="card-body p-5">
                    <!-- Resumen del Plan -->
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <h4 class="text-success">{{ $plan->nombre }}</h4>
                            <p class="text-muted mb-2">{{ $plan->descripcion }}</p>
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-success me-2">{{ $plan->tipo }}</span>
                                <small class="text-muted">{{ $plan->duracion }} meses</small>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <h3 class="text-success">${{ number_format($plan->precio, 2) }}</h3>
                            <small class="text-muted">Pago único</small>
                        </div>
                    </div>

                    <!-- Información del Usuario -->
                    <div class="alert alert-info mb-4">
                        <h6 class="alert-heading">
                            <i class="fas fa-user me-2"></i>Información de Facturación
                        </h6>
                        <p class="mb-0">{{ $user->name }} - {{ $user->email }}</p>
                    </div>

                    <!-- Formulario de Pago con Stripe -->
                    <div class="payment-section">
                        <h5 class="mb-4">
                            <i class="fas fa-credit-card me-2"></i>Información de Pago
                        </h5>
                        
                        <form id="payment-form">
                            @csrf
                            <input type="hidden" id="plan_id" value="{{ $plan->id }}">
                            
                            <div class="mb-4">
                                <label for="card-element" class="form-label fw-bold">Detalles de la Tarjeta</label>
                                <div id="card-element" class="form-control p-3" style="height: 50px;">
                                    <!-- Stripe Elements will be inserted here -->
                                </div>
                                <div id="card-errors" role="alert" class="text-danger mt-2 small"></div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" id="submit-button" class="btn btn-success btn-lg py-3 fw-bold">
                                    <span id="button-text">
                                        <i class="fas fa-lock me-2"></i>Pagar ${{ number_format($plan->precio, 2) }}
                                    </span>
                                    <span id="button-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Información de Seguridad -->
                    <div class="mt-4 text-center">
                        <p class="text-muted small">
                            <i class="fas fa-shield-alt me-2"></i>
                            Tus datos están protegidos con encriptación SSL de 256-bit
                        </p>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <img src="https://stripe.com/img/v3/home/twitter.png" alt="Stripe" height="30">
                            <img src="https://stripe.com/img/v3/home/security.svg" alt="SSL Secure" height="30">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Éxito -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>¡Pago Exitoso!
                </h5>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle text-success display-1 mb-3"></i>
                <h4 class="text-success mb-3">¡Bienvenido a Jeff Academy!</h4>
                <p class="text-muted">Tu suscripción ha sido activada exitosamente.</p>
                <p class="text-muted mb-4">Serás redirigido automáticamente a tu dashboard.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    
    // Estilo personalizado para los elementos
    const style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    const cardElement = elements.create('card', { style: style });
    cardElement.mount('#card-element');

    // Manejar errores de validación en tiempo real
    cardElement.on('change', ({error}) => {
        const displayError = document.getElementById('card-errors');
        if (error) {
            displayError.textContent = error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Manejar envío del formulario
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const buttonText = document.getElementById('button-text');
    const buttonSpinner = document.getElementById('button-spinner');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        
        // Deshabilitar botón y mostrar spinner
        submitButton.disabled = true;
        buttonText.classList.add('d-none');
        buttonSpinner.classList.remove('d-none');

        try {
            // Crear Payment Intent
            const response = await fetch('{{ route("payment.create-intent") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    plan_id: document.getElementById('plan_id').value
                })
            });

            const { clientSecret, paymentIntentId, transactionId, error } = await response.json();

            if (error) {
                throw new Error(error);
            }

            // Confirmar pago con Stripe
            const { error: stripeError, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardElement,
                }
            });

            if (stripeError) {
                throw new Error(stripeError.message);
            }

            // Confirmar pago en el servidor
            const confirmResponse = await fetch('{{ route("payment.confirm") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    payment_intent_id: paymentIntentId,
                    transaction_id: transactionId
                })
            });

            const confirmResult = await confirmResponse.json();

            if (confirmResult.success) {
                // Mostrar modal de éxito
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                
                // Redirigir después de 3 segundos
                setTimeout(() => {
                    window.location.href = '{{ route("platform") }}';
                }, 3000);
            } else {
                throw new Error(confirmResult.message);
            }

        } catch (error) {
            // Mostrar error y habilitar botón
            alert('Error: ' + error.message);
            submitButton.disabled = false;
            buttonText.classList.remove('d-none');
            buttonSpinner.classList.add('d-none');
        }
    });
</script>

<style>
.payment-section {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 2rem;
    background: #f8f9fa;
}

#card-element {
    border: 1px solid #ced4da;
    border-radius: 5px;
    padding: 10px 12px;
    background: white;
}

.StripeElement--focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.StripeElement--invalid {
    border-color: #dc3545;
}
</style>
@endpush