<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'foto_perfil',
        'telefono',
        'stripe_customer_id',
        'is_active',
        'direccion',
        'fecha_nacimiento',
        'biografia',
        'enlaces',
        'altura',
        'peso',
        'posicion',
        'categoria',
        'numero_jersey',
        'especialidad',
        'anos_experiencia',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'fecha_nacimiento' => 'date',
        'enlaces' => 'array',
        'altura' => 'decimal:2',
        'peso' => 'decimal:2',
        'anos_experiencia' => 'integer',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // NUEVAS RELACIONES PARA EL SISTEMA DE PAGOS
    public function subscriptions()
    {
        return $this->hasMany(PlanSubscription::class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(PlanSubscription::class)
            ->where('status', 'active')
            ->where('end_date', '>', now());
    }

    public function hasActiveSubscription()
    {
        return $this->activeSubscription()->exists();
    }

    // Métodos para Stripe
    public function getStripeCustomer()
    {
        if (!$this->stripe_customer_id) {
            $this->createStripeCustomer();
        }
        return $this->stripe_customer_id;
    }

    private function createStripeCustomer()
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        
        $customer = \Stripe\Customer::create([
            'email' => $this->email,
            'name' => $this->name,
            'metadata' => ['user_id' => $this->id]
        ]);
        
        $this->stripe_customer_id = $customer->id;
        $this->save();
    }

    // Métodos de utilidad
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPlayer()
    {
        return $this->role === 'player';
    }

    public function isCoach()
    {
        return $this->role === 'coach';
    }

    public function activateAccount()
    {
        $this->update(['is_active' => true, 'activo' => true]);
    }

    public function deactivateAccount()
    {
        $this->update(['is_active' => false, 'activo' => false]);
    }

    // Relaciones
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'jugador_id');
    }

    public function inscripcionesComoEntrenador()
    {
        return $this->hasMany(Inscripcion::class, 'entrenador_id');
    }

    public function entrenamientos()
    {
        return $this->hasMany(Entrenamiento::class, 'entrenador_id');
    }

    public function anuncios()
    {
        return $this->hasMany(Anuncio::class, 'user_id');
    }

    // Accessors
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento
            ? $this->fecha_nacimiento->age
            : null;
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto_perfil) {
            // Si es URL de Gravatar
            if (str_starts_with($this->foto_perfil, 'http')) {
                return $this->foto_perfil;
            }
            // Si es archivo local
            return asset('storage/' . $this->foto_perfil);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=200&background=3B82F6&color=fff';
    }
}
