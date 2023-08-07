<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Media;
use App\Models\MediaType;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function store(Request $request, User $user){
        try{
            $credentials = $request->all();
            $credentials['password'] = bcrypt($credentials['password']);
            $credentials['cpf'] = preg_replace('/\D/', '', $credentials['cpf']);
            $credentials['phone'] = preg_replace('/\D/', '', $credentials['phone']);

            if($user->validateCPF($credentials['cpf'])['status'] == 500){
                return response()->json([
                    'status' => $user->validateCPF($credentials['cpf'])['status'],
                    'data' => $user->validateCPF($credentials['cpf'])['data']
                ],$user->validateCPF($credentials['cpf'])['status']);
            }

            $user = $user->create($credentials);
            if($user){
                return response()->json([
                    'data' =>[
                        'user' => $user,
                    ]
                ]);
            }
        }catch(\Throwable $th){
            return response()->json([
                'status' => 500,
                'data' => 'Erro no registro de usuário - AccountController',
                'msg' => $th->getMessage()
            ], 500);
        }
    }

    public function login(Request $request, User $user){
        try{
            $credentials = $request->only('cpf', 'password');
            $credentials['cpf'] = preg_replace('/\D/', '', $credentials['cpf']);
            if(!auth()->attempt($credentials))
                return response([
                    'status' => 401,
                    'data' => 'Erro ao logar usuário',
                    'msg' => ['text' => 'Credenciais invalidas'],
                    'credentials' => $credentials
                ],401);
            $token = auth()->user()->createToken('mv_user');

            if(!$user->where('cpf', $credentials['cpf'])->update(['token' => $token->plainTextToken])){
                abort(500, 'Erro ao registrar token');
            }

            return response()->json([
                'token' => $token->plainTextToken,
                'data' =>[
                    'user' => $user->where('cpf', $credentials['cpf'])->first()
                ]
            ]);

        }catch(\Throwable $th){
            return response()->json([
                'status' => $th->getStatus(),
                'data' => 'Erro ao logar usuário',
                'msg' => ['msg' =>'Credenciais invalidas', 'credentials' => $th->getMessage()]
            ], 500);
        }
    }
    public function uploadLogo(Request $request, Media $media, MediaType $tipo){
        try{
            $tipo = $tipo->where('name', $request['media_type'])->get()->first();
            $request->validate([
                'file' => 'required|mimes:jpg,jpeg,png,csv|max:2048'
            ]);
            if($request->file){
                $file_name = $tipo->name.'.'.$request->file->extension();
                $file_path = $request->file('file')->storeAs('uploads/img', $file_name, 'vue-storage');

                if(count($media->where('media_type', $tipo->id)->get()) == 0){
                    $media->create([
                        'name' => $file_name,
                        'path' => 'assets/'.$file_path,
                        'media_type' => $tipo->id
                    ]);
                }
                else{
                    $media = $media->where('media_type', $tipo->id)->get()->first();
                    $media->update([
                        'name' => $file_name,
                        'path' => 'assets/'.$file_path,
                        'media_type' => $tipo->id
                    ]);
                }
                return response()->json([
                    'status' => 200, 
                    'data' => $media
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 500, 
                    'data' => 'Sem File'
                ], 500);
            }
        }catch(\Throwable $th){
            return response()->json([
                //'status' => $th->getStatus(),
                'data' => 'Salvar Imagem',
                'msg' => $th->getMessage()
            ], 500);
        }
    }
    public function getLogo(Media $media, MediaType $tipo){
      try{
        $tipo = $tipo->where('name', 'logo')->get()->first();
        //$media->where($media->where('media_type', $tipo->id)->get())->get();
        return response($media->where("media_type", $tipo->id)->get()->first(), 200);
      }catch(\Throwable $th){
        return response()->json([
            //'status' => $th->getStatus(),
            'data' => 'Erro ao pegar logo',
            'msg' => $th->getMessage()
        ], 500);
    }
    }
    
}
