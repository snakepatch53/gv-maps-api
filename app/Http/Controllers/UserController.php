<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            "password" => "required"
        ], [
            "email.required" => "El campo email es requerido",
            "password.required" => "El campo password es requerido"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors(),
                "data" => null
            ]);
        }

        // if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]) && !Auth::attempt(['user' => $request->email, 'password' => $request->password])) {
            return response()->json([
                "success" => false,
                "message" => "Credenciales incorrectas",
                "errors" => null,
                "data" => null
            ]);
        }
        // incluir la entity del usuario

        $user = User::where('email', $request->email)->with('entity')->first();

        // $user = User::where('email', $request->email)->first();

        $token = $user->createToken('authToken')->plainTextToken;
        $user->token = $token;

        return response()->json([
            "success" => true,
            "message" => "Sesión iniciada",
            "errors" => null,
            "data" => $user,
            "token" => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "success" => true,
            "message" => "Sesión cerrada",
            "errors" => null,
            "data" => null
        ]);
    }

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(),  [
    //         "name" => "required|min:3|max:150",
    //         "lastname" => "required|min:3|max:150",
    //         "photo" => "file|mimes:" . $this->IMAGE_TYPE,
    //         "phone" => "required|min:10|max:15",
    //         "address" => "required|min:5|max:250",
    //         "email" => "required|email|unique:users,email",
    //         "password" => "required|min:8"
    //     ], [
    //         "name.required" => "El campo nombre es requerido",
    //         "name.min" => "El campo nombre debe tener al menos 3 caracteres",
    //         "name.max" => "El campo nombre debe tener como máximo 150 caracteres",
    //         "lastname.required" => "El campo apellido es requerido",
    //         "lastname.min" => "El campo apellido debe tener al menos 3 caracteres",
    //         "lastname.max" => "El campo apellido debe tener como máximo 150 caracteres",
    //         "photo.file" => "El campo foto debe ser un archivo",
    //         "photo.mimes" => "El campo foto debe ser un archivo de tipo: " . $this->IMAGE_TYPE,
    //         "phone.required" => "El campo teléfono es requerido",
    //         "phone.min" => "El campo teléfono debe tener al menos 10 caracteres",
    //         "phone.max" => "El campo teléfono debe tener como máximo 15 caracteres",
    //         "address.required" => "El campo dirección es requerido",
    //         "address.min" => "El campo dirección debe tener al menos 10 caracteres",
    //         "address.max" => "El campo dirección debe tener como máximo 250 caracteres",
    //         "email.required" => "El campo email es requerido",
    //         "email.email" => "El campo email debe ser un correo electrónico válido",
    //         "email.unique" => "El campo email ya está en uso",
    //         "password.required" => "El campo password es requerido",
    //         "password.min" => "El campo password debe tener al menos 8 caracteres"
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             "success" => false,
    //             "message" => $validator->errors()->first(),
    //             "errors" => $validator->errors(),
    //             "data" => null
    //         ]);
    //     }

    //     if ($request->file("photo")) {
    //         $fileName_photo = basename($request->file("photo")->store($this->PHOTO_PATH));
    //         $request = new Request($request->except(["photo"]) + ["photo" => $fileName_photo]);
    //     }

    //     if ($request->password) $request->merge(["password" => Hash::make($request->password)]);

    //     $request->merge(["confirmation_code" => md5($request->email)]);
    //     //todo Aqui podriamos llamar una fiuncion para enviar un correo con el codigo de confirmacion

    //     $data = User::create($request->all());

    //     $token = $data->createToken('authToken')->plainTextToken;
    //     $data->token = $token;

    //     return response()->json([
    //         "success" => true,
    //         "message" => "Recurso creado",
    //         "errors" => null,
    //         "data" => $data,
    //         "token" => $token,
    //     ]);
    // }

    public function existSession()
    {
        $id = Auth::id();
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "No hay sesión iniciada",
                "errors" => null,
                "data" => null
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "Sesión iniciada",
            "errors" => null,
            "data" => $user
        ]);
    }

    public function index(Request $request)
    {
        $includes = [];
        if ($request->query('includeEntity')) $includes[] = 'entity';
        if ($request->query('includeMaps')) $includes[] = 'maps';

        // Restringimos el acceso dependiendo del rol del usuario
        $data = [];
        $data = User::with($includes)->get();

        return response()->json([
            "success" => true,
            "message" => "Recursos encontrados",
            "data" => $data
        ]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
