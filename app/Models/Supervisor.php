<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Mail;

class Supervisor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = 'supervisor';
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // public function generateCode()
    // {
    //     $code = rand(1000, 9999);
  
    //     UserCode::updateOrCreate(
    //         [ 'user_id' => auth()->user()->id ],
    //         [ 'code' => $code ]
    //     );
    
    //     try {
  
            
    //         //$pdf = \PDF::loadView('emails.code', $details);
    //         //$content = PDF::loadView('emails.code', $details)->output();
    //         //$name = $pdf -> getClientOriginalName();
    //         // $store=Store::disk('spaces')->put('/escenario-5-spaces-la/documentos/pdf/'.$name,$content);
    //         //Storage::disk('spaces')->put($code.'.txt','tu codigo de acceso es: '.$code,'public');
    //         //$file = Storage::disk('spaces')->url($code.'.txt');

    //         //$fileurlcdn = str_replace("digitaloceanspaces","cdn.digitaloceanspaces",$file);
    //         //$url = Storage::url($code.'.txt');
    //         //error_log('Some message here.');
    //         //error_log($file);
    //         //error_log($fileurlcdn);
    //         $details = [
    //             'title' => 'Mail enviado por el Escenario #2',
    //             'code' => $code
    //             //'url' => $file
    //         ];
            
            
    //         Mail::to(auth()->user()->email)->send(new SendCodeMail($details));
    //     } catch (Exception $e) {
    //         info("Error: ". $e->getMessage());
    //     }
    // }
}
