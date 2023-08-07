<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'user';
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'cpf',
        'token',
        'phone',
        'password',
        'admin',
    ];
    public function validateCPF($cpf){
        if(empty($cpf)) {
            return ['status' => 500, 'data' => "O CPF é obrigatório"];
        }
  
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
  
        if (strlen($cpf) != 11) {
          return ['status' => 500,'data' => "O CPF deve conter 11 dígitos"];
        }
  
        else if ($cpf == '00000000000' || 
          $cpf == '11111111111' || 
          $cpf == '22222222222' || 
          $cpf == '33333333333' || 
          $cpf == '44444444444' || 
          $cpf == '55555555555' || 
          $cpf == '66666666666' || 
          $cpf == '77777777777' || 
          $cpf == '88888888888' || 
          $cpf == '99999999999') {
          return ['status' => 500, 'data' => "CPF inválido"];
        }
  
        else {   
           
          for ($t = 9; $t < 11; $t++) {
               
              for ($d = 0, $c = 0; $c < $t; $c++) {
                  $d += $cpf[$c] * (($t + 1) - $c);
              }
              $d = ((10 * $d) % 11) % 10;
              if ($cpf[$c] != $d) {
                  return ['status' => 500,'data' =>"CPF inválido"];
              }
          }

          if(count($this->where("cpf", $cpf)->get()) > 0)
                return response()->json([
                    'status' => 500,
                    'data' => 'Este CPF já foi utilizado!'
                ],500);
   
          return ['status' => 200, 'data' =>"CPF válido"];
        }
      }

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
/*     protected $casts = [
        'email_verified_at' => 'datetime',
    ]; */
}
