<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\Validator;


class PersonController extends Controller
{
    //
    public function index()
    {
        $students = Person::all();

        if ($students->isEmpty()) {
            $data = [
                'message' => 'No se encontraron estudiantes',
                'status' => 200
            ];
            return response()->json($data, 404);
        }

        $data = [
            'students' => $students,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:person',
            'code' => 'required|max:6',
            'phone' => 'required|digits:8',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $person = Person::create([
            'name' => $request->name,
            'email' => $request->email,
            'code' => $request->code,
            'phone' => $request->phone]);

        if (!$person) {
            $data = [
                'message' => 'Error al crear al usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'Person' => $person,
            'status' => 201
        ];

        return response()->json($data, 201);

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|email|unique:person,email,'. $id,
            'code' => 'sometimes|required|max:6',
            'phone' => 'sometimes|required|digits:8',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $person = Person::find($id);

        if (!$person) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $person->update($request->all());

        $data = [
            'Person' => $person,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'EMAIL' => 'required|email',
            'CODE' => 'required|max:6',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $person = Person::where('email', $request->EMAIL)->where('code', $request->CODE)->first();

        if (!$person) {
            $data = [
                'message' => 'Credenciales incorrectas',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Inicio de sesión exitoso',
            'Person' => $person,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
