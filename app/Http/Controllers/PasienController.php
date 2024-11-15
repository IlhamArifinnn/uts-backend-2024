<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Generator\StringManipulation\Pass\Pass;

class PasienController extends Controller
{

    public function index()
    {
        $pasien = Pasien::all();

        if ($pasien) {
            $data = [
                'message' => 'Get all patients',
                'data' => $pasien,
            ];
        } else {
            $data = [
                'message' => 'Patient is empty',
            ];
        }

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'phone' => 'string|required',
            'address' => 'string|required',
            'status' => 'string|required',
            'in_date_at' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pasien = Pasien::create($request->all());

        $data = [
            'message' => 'Patient is created successfully',
            'data' => $pasien,
        ];

        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::find($id);

        if ($pasien) {
            $input = [
                'name' => $request->name ?? $pasien->name,
                'phone' => $request->phone ?? $pasien->phone,
                'address' => $request->address ?? $pasien->address,
                'status' => $request->status ?? $pasien->status,
                'in_date_at' => $request->in_date_at ?? $pasien->in_date_at,
            ];

            $pasien->update($input);

            $data = [
                'message' => 'patient is updated',
                'data' => $pasien,
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Patient not found',
            ];

            return response()->json($data, 404);
        }
    }

    public function destroy($id)
    {
        $pasien = Pasien::find($id);

        if ($pasien) {
            $pasien->delete();

            $data = [
                'message' => 'Patient is deleted',
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Patient not found',
            ];

            return response()->json($data, 404);
        }
    }

    public function show($id)
    {
        $pasien = Pasien::find($id);

        if ($pasien) {
            $data = [
                'message' => 'Get detail patient',
                'data' => $pasien
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'patient not found',
            ];

            return response()->json($data, 404);
        }
    }


    public function search($name)
    {
        $pasien = Pasien::where('name', 'like', "%$name%")->get();

        if ($pasien->count() > 0) {
            $data = [
                'message' => 'Get searched patient',
                'data' => $pasien
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'No patient found',
            ];
            return response()->json($data, 404);
        }
    }
}
