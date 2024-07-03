<?php

namespace App\Http\Controllers;

use App\Mail\VerificacionCuenta;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{

    public function registroIniciarSesion(Request $request): JsonResponse | RedirectResponse
    {

        $input = $request->all();

        $input['correo'] = $this->satinizar($input['correo']);
        $input['clave'] = $this->satinizar($input['clave']);

        $validator = Validator::make($input, [
            'correo' => 'required|email|max:255',
            'clave' => 'required|min:8|max:20',
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe ser una dirección válida.',
            'correo.max' => 'El correo no puede tener más de 255 caracteres.',
            'clave.required' => 'La clave es obligatoria.',
            'clave.min' => 'La clave debe tener al menos 8 caracteres.',
            'clave.max' => 'La clave no puede tener más de 20 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'estado' => 'error',
                'mensaje' => $validator->errors()
            ], 422);
        }

        $usuario = Usuario::where('correo', $input['correo'])->first();



        if ($usuario) {
            if (Hash::check($input['clave'], $usuario->clave)) {
                Auth::login($usuario);
                return redirect()->route("perfil");
            } else {
                return response()->json([
                    'estado' => 'error',
                    'mensaje' => 'La contraseña es incorrecta.',
                    "tipo"=>"login"
                ], 401);
            }
        }

        $token_verificacion = Str::random(60);

        $fecha_expiracion = Carbon::now()->addHours(24);

        $usuarioNuevo = Usuario::create([
            'correo' => $input['correo'],
            'clave' => bcrypt($input['clave']),
            'token_verificacion' => "$token_verificacion",
            'esta_verificado' => false,
            'fecha_expiracion_verificacion' => "$fecha_expiracion",
        ]);

        $usuarioNuevo->save();

        Mail::to($input['correo'])->send(new VerificacionCuenta($token_verificacion));

        return response()->json([
            'estado' => 'ok',
            'mensaje' => 'Usuario registrado exitosamente.',
            "tipo" => "registro"
        ], 201);


    }

    public function verificarCuenta($token): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $user = Usuario::where('token_verificacion', $token)->first();

        if (!$user) {
            return view('verificar_cuenta', ['estado' => 'error', 'mensaje' => 'Token de verificación no válido.']);
        }

        if ($user->esta_verificado) {
            return view('verificar_cuenta', ['estado' => 'error', 'mensaje' => 'Este token ya ha sido utilizado para verificar el correo electrónico.']);
        }

        if ($user->fecha_expiracion_verificacion && Carbon::parse($user->fecha_expiracion_verificacion)->lt(Carbon::now())) {
            return view('verificar_cuenta', ['estado' => 'error', 'mensaje' => 'El enlace de verificación ha expirado. Por favor, solicita un nuevo enlace de verificación.']);
        }

        $user->update([
            'esta_verificado' => true,
            'fecha_verificacion' => Carbon::now(),
            'token_verificacion' => null,
            'fecha_expiracion_verificacion' => null,
        ]);

        return view('verificar_cuenta', ['estado' => 'ok', 'mensaje' => 'Correo electrónico verificado exitosamente.']);
    }

    public function satinizar($input): string
    {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
    public function mostrarPerfil()
    {
        $usuario = Auth::user();
        return view("usuario_perfil",["usuario"=>$usuario]);
    }

}
