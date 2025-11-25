<?php
// app/Http/Controllers/PagoStripeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use App\Models\ConfiguracionContacto;

class PagoStripeController extends Controller
{
    public function procesarPago(Request $request)
    {
        Log::info('Iniciando procesamiento de pago', ['plan_id' => $request->plan_id]);

        $request->validate([
            'plan_id' => 'required|exists:planes,id',
        ]);

        // Obtener plan
        $plan = DB::table('planes')->where('id', $request->plan_id)->first();

        if (!$plan || $plan->estado !== 'activo') {
            Log::warning('Plan no disponible', ['plan_id' => $request->plan_id]);
            return back()->with('error', 'Este plan no está disponible actualmente.');
        }

        Log::info('Plan encontrado', ['plan' => $plan]);

        try {
            // Verificar que la clave de Stripe esté configurada
            $stripeSecret = config('services.stripe.secret');
            
            if (!$stripeSecret || strpos($stripeSecret, 'sk_test_') === false) {
                Log::error('Clave de Stripe no configurada correctamente');
                return back()->with('error', 'Error de configuración del sistema de pagos.');
            }

            Log::info('Configurando Stripe con clave');
            Stripe::setApiKey($stripeSecret);

            // Crear sesión de checkout
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'pen',
                        'product_data' => [
                            'name' => $plan->nombre,
                            'description' => $plan->descripcion ?? 'Suscripción mensual',
                        ],
                        'unit_amount' => (int)($plan->precio * 100), // Asegurar que sea entero
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}&plan_id=' . $plan->id,
                'cancel_url' => route('payment.cancel'),
                'metadata' => [
                    'plan_id' => $plan->id,
                    'plan_nombre' => $plan->nombre,
                ],
            ]);

            Log::info('Sesión de Stripe creada', ['session_id' => $session->id]);

            return redirect()->away($session->url);

        } catch (ApiErrorException $e) {
            Log::error('Error de Stripe API: ' . $e->getMessage());
            return back()->with('error', 'Error de conexión con la pasarela de pagos: ' . $e->getError()->message);
        } catch (\Exception $e) {
            Log::error('Error inesperado: ' . $e->getMessage());
            return back()->with('error', 'Error interno del sistema. Por favor, contacta con soporte.');
        }
    }

   public function pagoExitoso(Request $request)
{
    $sessionId = $request->get('session_id');
    $planId = $request->get('plan_id');
    
    try {
        // Configurar Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
        
        // Recuperar sesión de Stripe
        $session = Session::retrieve($sessionId);
        
        // Obtener plan de la base de datos
        $plan = DB::table('planes')->where('id', $planId)->first();
        
        // Obtener el ID del registro desde la sesión (IMPORTANTE: usar session('registro_id'))
        $registro_id = session('registro_id');
        
        \Log::info('Datos de pago exitoso:', [
            'registro_id' => $registro_id,
            'plan_id' => $planId,
            'session_id' => $sessionId,
            'plan' => $plan
        ]);

        if ($registro_id && $plan) {
            // Guardar la suscripción en plan_subscriptions usando user_id (que ahora referencia a registros.id)
            DB::table('plan_subscriptions')->insert([
                'user_id' => $registro_id,  // Esto es el ID de la tabla registros
                'plan_id' => $plan->id,
                'stripe_subscription_id' => $sessionId,
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addMonths($plan->duracion ?? 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \Log::info('Suscripción guardada exitosamente', [
                'user_id' => $registro_id,
                'plan_id' => $plan->id,
                'plan_nombre' => $plan->nombre
            ]);
            
            // Debug: Verificar que se guardó
            $suscripcionGuardada = DB::table('plan_subscriptions')
                ->where('user_id', $registro_id)
                ->where('plan_id', $plan->id)
                ->first();
                
            \Log::info('Suscripción verificada:', ['suscripcion' => $suscripcionGuardada]);
            
        } else {
            \Log::error('No se pudo guardar la suscripción - Datos faltantes', [
                'registro_id' => $registro_id,
                'plan' => $plan
            ]);
        }
        
        return view('payment.success', [
            'plan' => $plan,
            'plan_id' => $planId,
            'session_id' => $sessionId,
            'session' => $session,
            'config' => ConfiguracionContacto::obtener()
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error en pago exitoso: ' . $e->getMessage());
        \Log::error('Trace: ' . $e->getTraceAsString());
        
        return view('payment.success')->with('error', 'Hubo un error al procesar tu suscripción. Por favor contacta a soporte.')->with('config', ConfiguracionContacto::obtener());
    }
}

    public function pagoCancelado()
    {
        return view('pagos.cancelado');
    }
}