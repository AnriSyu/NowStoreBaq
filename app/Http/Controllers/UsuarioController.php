<?php

namespace App\Http\Controllers;

use App\Mail\CambiarClave;
use App\Mail\ClaveCambiada;
use App\Mail\VerificacionCuenta;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{

    public function mostrarIngresar(){
        $usuario = Auth::user();
        if($usuario):
            $rol = Rol::where('id',$usuario->id_rol)->first();
            if($rol->rol === "administrador"):
                return redirect("admin/dashboard");
            endif;
            return redirect("perfil");
        endif;
        return view("usuario.usuario_ingresar");
    }

    public function cerrarSesion()
    {
        Auth::logout();
        return redirect("/");
    }

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

        if ($validator->fails()):
            return response()->json([
                'estado' => 'error',
                'mensaje' => $validator->errors()
            ], 422);
        endif;

        $usuario = Usuario::where('correo', $input['correo'])->first();

        if ($usuario):
            if (Hash::check($input['clave'], $usuario->clave)):
                $rol = Rol::where('id',$usuario->id_rol)->first();
                Auth::login($usuario);

                if($rol->rol == 'administrador'):
                    return redirect("admin");
                endif;

                return response()->json([
                    'estado' => 'ok',
                    'mensaje' => 'Login exitoso',
                    "tipo"=>"login"
                ], 201);

            else:

                return response()->json([
                    'estado' => 'error',
                    'mensaje' => 'Correo o clave incorrectos.',
                    "tipo"=>"login"
                ], 401);

            endif;
        endif;

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

        if (!$user):
            return view('usuario.verificar_cuenta', ['estado' => 'error', 'mensaje' => 'Token de verificación no válido.']);
        endif;

        if ($user->esta_verificado):
            return view('usuario.verificar_cuenta', ['estado' => 'error', 'mensaje' => 'Este token ya ha sido utilizado para verificar el correo electrónico.']);
        endif;

        if ($user->fecha_expiracion_verificacion && Carbon::parse($user->fecha_expiracion_verificacion)->lt(Carbon::now())):
            return view('usuario.verificar_cuenta', ['estado' => 'error', 'mensaje' => 'El enlace de verificación ha expirado. Por favor, solicita un nuevo enlace de verificación.']);
        endif;

        $user->update([
            'esta_verificado' => true,
            'fecha_verificacion' => Carbon::now(),
            'token_verificacion' => null,
            'fecha_expiracion_verificacion' => null,
        ]);

        return view('usuario.verificar_cuenta', ['estado' => 'ok', 'mensaje' => 'Correo electrónico verificado exitosamente.']);
    }

    public function satinizar($input): string
    {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
    public function mostrarPerfil()
    {
        $usuario = Auth::user();
        return view("usuario.usuario_perfil",["usuario"=>$usuario]);
    }


    public function recuperarCuenta(Request $request){
        $input = $request->all();

        $input["input_correo"] = $this->satinizar($input['input_correo']);

        $validator = Validator::make($input, [
            'input_correo' => 'required|email|max:255',
        ], [
            'input_correo.required' => 'Debes escribir un correo.',
            'input_correo.email' => 'El correo debe ser una dirección válida.',
            'input_correo.max' => 'El correo no puede tener más de 255 caracteres.',
        ]);

        if ($validator->fails()):
            return redirect()->back()->withErrors($validator)->withInput();
        endif;


        $usuario = Usuario::where('correo', $input["input_correo"])->first();

        if ($usuario):
            $token = Str::random(60);
            $usuario->token_cambio_clave = $token;
            $usuario->fecha_expiracion_cambio_clave = Carbon::now()->addMinutes(60);
            $usuario->save();

            Mail::to($input['input_correo'])->send(new CambiarClave($token));

        endif;

        return back()->with('status', 'Si tu correo electrónico está registrado, se le enviará un enlace para cambiar su contraseña.');

    }

    public function cambiarClave($token) {
        $user = Usuario::where('token_cambio_clave', $token)->first();

        if (!$user):
            return view('usuario.cambiar_clave', ['estado' => 'error', 'mensaje' => 'Token de cambio de clave no válido.']);
        endif;

        if ($user->fecha_expiracion_cambio_clave && Carbon::parse($user->fecha_expiracion_cambio_clave)->lt(Carbon::now())):
            return view('usuario.cambiar_clave', ['estado' => 'error', 'mensaje' => 'El enlace de cambio de clave ha expirado. Por favor, solicita un nuevo enlace de cambio de clave.']);
        endif;

        return view('usuario.cambiar_clave', ['estado' => 'ok', 'token' => $token]);
    }

    public function actualizarClave(Request $request)
    {

        $input = $request->all();

        $input['input_clave'] = $this->satinizar($input['input_clave']);
        $input['input_clave_repetir'] = $this->satinizar($input['input_clave_repetir']);

        $validator = Validator::make($input, [
            'token' => 'required',
            'input_clave' => 'required|string|min:8|same:input_clave_repetir',
            'input_clave_repetir' => 'required|string|min:8',
        ], [
            'input_clave.required' => 'La clave es obligatoria.',
            'input_clave.min' => 'La clave debe tener al menos 8 caracteres.',
            'input_clave.max' => 'La clave no puede tener más de 20 caracteres.',
            'input_clave_repetir.required' => 'La clave es obligatoria.',
            'input_clave_repetir.min' => 'La clave debe tener al menos 8 caracteres.',
            'input_clave_repetir.max' => 'La clave no puede tener más de 20 caracteres.',
            'input_clave.same' => 'Las dos claves deben ser iguales'
        ]);

        if ($validator->fails()):
            return redirect()->back()->withErrors($validator)->withInput();
        endif;

        $user = Usuario::where('token_cambio_clave', $request->token)
            ->where('fecha_expiracion_cambio_clave', '>=', Carbon::now())
            ->first();

        if (!$user):
            return back()->withErrors(['other_error' => 'El token es inválido o ha expirado.']);
        endif;

        if($user->clave == $input['input_clave']):
            return back()->withErrors(['other_error'=> 'La nueva contraseña no puede ser la misma que la anterior.']);
        endif;

        $user->clave = bcrypt($input['input_clave']);
        $user->token_cambio_clave = null;
        $user->fecha_expiracion_cambio_clave = null;
        $user->fecha_ultimo_cambio_clave = Carbon::now();
        $user->save();

        Mail::to($user->correo)->send(new ClaveCambiada());

        return back()->with('status', 'Tu clave ha sido actualizada.');
    }
}
