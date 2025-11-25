<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;


class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'plan_id' => 'required|exists:planes,id',
                'plan_nombre' => 'required|string',
                'plan_precio' => 'required|numeric|min:0',
                'duracion' => 'required|integer|min:1'
            ]);

            $planId = $request->plan_id;
            $planNombre = $request->plan_nombre;
            $planPrecio = $request->plan_precio;
            
            // Configurar Stripe
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            // Crear sesión de Checkout de Stripe
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'pen',
                        'product_data' => [
                            'name' => $planNombre,
                            'description' => 'Suscripción mensual - ' . $planNombre,
                        ],
                        'unit_amount' => $planPrecio * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url('/payment/success') . '?session_id={CHECKOUT_SESSION_ID}&plan_id=' . $planId,
                'cancel_url' => url('/payment/cancel'),
                'metadata' => [
                    'plan_id' => $planId,
                    'plan_nombre' => $planNombre,
                    'duracion' => $request->duracion,
                    'user_id' => auth()->id() ?? 'guest',
                ],
            ]);

            return redirect()->away($session->url);

        } catch (ApiErrorException $e) {
            return back()->with('error', 'Error de Stripe: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    public function paymentSuccess(Request $request)
    {
        try {
            $sessionId = $request->get('session_id');
            $planId = $request->get('plan_id');
            
            if (!$sessionId) {
                return redirect()->route('registro.elegir-plan')->with('error', 'Sesión de pago no válida');
            }

            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = Session::retrieve($sessionId);
            
            if ($session->payment_status === 'paid') {
                $this->registrarInscripcion($planId, $sessionId, auth()->id());
                
                return view('payment.success', [
                    'plan_nombre' => $session->metadata->plan_nombre,
                    'amount_total' => $session->amount_total / 100,
                    'session_id' => $sessionId
                ]);
            } else {
                return redirect()->route('payment.cancel')->with('error', 'El pago no se completó');
            }

        } catch (\Exception $e) {
            return redirect()->route('registro.elegir-plan')->with('error', 'Error al verificar el pago: ' . $e->getMessage());
        }
    }

    public function paymentCancel()
    {
        return view('payment.cancel');
    }

    private function registrarInscripcion($planId, $sessionId, $userId)
    {
        DB::table('inscripciones')->insert([
            'user_id' => $userId ?? 1, // Temporal: usar ID 1 si no hay usuario autenticado
            'plan_id' => $planId,
            'session_id' => $sessionId,
            'fecha_inscripcion' => now(),
            'fecha_expiracion' => now()->addMonth(),
            'estado' => 'activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}