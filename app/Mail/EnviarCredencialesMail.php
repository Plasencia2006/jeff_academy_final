<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarCredencialesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $password;
    public $mensajePersonalizado;

    public function __construct($usuario, $password, $mensajePersonalizado = '')
    {
        $this->usuario = $usuario;
        $this->password = $password;
        $this->mensajePersonalizado = $mensajePersonalizado;
    }

    public function build()
    {
        return $this->from('hectorisaiplasenciaalva923@gmail.com', 'JEFF ACADEMY')
                    ->replyTo('hectorisaiplasenciaalva923@gmail.com', 'Soporte Jeff Academy')
                    ->subject('Tus Credenciales de Acceso - Jeff Academy')
                    ->view('emails.credenciales')
                    ->with([
                        'usuario' => $this->usuario,
                        'password' => $this->password,
                        'mensajePersonalizado' => $this->mensajePersonalizado,
                    ]);
    }
}