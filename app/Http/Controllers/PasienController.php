<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Generator\StringManipulation\Pass\Pass;

class PasienController extends Controller
{


    /**
    Menampilkan semua pasien yang ada di database.
    Hanya bisa diakses oleh pengguna yang sudah login.
    Mengembalikan data pasien dalam format JSON dengan status 200 (OK).
     */
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


    /**
      Menyimpan data pasien baru.
      Hanya bisa diakses oleh pengguna yang sudah login.
      Mengembalikan data pasien yang baru dibuat dan pesan sukses dengan status 201 (Created).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'phone' => 'string|required',
            'address' => 'string|required',
            'status' => 'string|required|in:positive,recovered,dead',
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


    /**
     * Memperbarui data pasien yang sudah ada berdasarkan ID.
     * Hanya bisa diakses oleh pengguna yang sudah login.
     * Data yang diterima harus melalui proses validasi terlebih dahulu.
     * Mengembalikan data pasien yang telah diperbarui dan pesan sukses dengan status 200 (OK).
     */
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


    /**
     * Menghapus pasien tertentu berdasarkan ID.
     * Hanya bisa diakses oleh pengguna yang sudah login.
     * Mengembalikan pesan sukses dengan status 200 (OK) setelah berita dihapus.
     */
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


    /**
     * Menampilkan pasien tertentu berdasarkan ID.
     * Hanya bisa diakses oleh pengguna yang sudah login.
     * Mengembalikan data pasien yang diminta dalam format JSON dengan status 200 (OK).
     */
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


    /** Menampilkan semua pasien dengan status positif */
    public function positive()
    {
        $pasien = Pasien::where('status', 'positive')->get();

        if ($pasien->count() > 0) {
            $data = [
                'message' => 'Get positive patients status',
                'total' => $pasien->count(),
                'data' => $pasien
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'No positive patients found',
            ];
            return response()->json($data, 404);
        }
    }

    /** Menampilkan semua pasien dengan status sembuh */
    public function recovered()
    {
        $pasien = Pasien::where('status', 'recovered')->get();

        if ($pasien->count() > 0) {
            $data = [
                'message' => 'Get recovered patient',
                'total' => $pasien->count(),
                'data' => $pasien
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'No recovered patients found',
            ];
            return response()->json($data, 404);
        }
    }

    public function dead()
    {
        $pasien = Pasien::where('status', 'dead')->get();

        if ($pasien->count() > 0) {
            $data = [
                'message' => 'Get dead patients',
                'total' => $pasien->count(),
                'data' => $pasien
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'No deceased patients found',
            ];
            return response()->json($data, 404);
        }
    }
}
