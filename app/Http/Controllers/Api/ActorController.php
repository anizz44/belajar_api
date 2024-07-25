<?php

namespace App\Http\Controllers\Api;

use App\Models\Actor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ActorController extends Controller
{
    public function index(){
        $actor = Actor::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Data actor',
            'data' => $actor,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request){
        // validasi data
        $validator = Validator::make($request->all(), [
            'nama_actor' => 'required|unique:actors',
            'bio' => 'required'
        ], [
            'nama_actor.required' => 'Masukan Actor',
            'nama_actor.unique' => 'Actor Sudah digunakan!',
            'bio.required' => 'Masukan Biodata',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'massage' => 'Silahkan isi dengan benar!',
                'data' => $validator->errors(),
            ], 401);
        } else {
            $actor = new Actor;
            $actor->nama_actor = $request->nama_actor;
            $actor->bio = $request->bio;
            $actor->save();
        }

        if ($actor) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ], 200);
        } else {
            return response()->json([
                'succes' => false,
                'message' => 'Data gagal disimpan',
            ], 400);
        }
    }

    public function show($id) {
        $actor = Actor::find($id);

        if ($actor) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Actor',
                'data' => $actor,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Actor tidak ditemukan',
                'data' => '',
            ], 404);
        }
    }

    public function update(Request $request, $id){
        // validasi data
        $validator = Validator::make($request->all(), [
            'nama_actor' => 'required',
            'bio' => 'required',
        ], [
            'nama_actor.required' => 'Masukan Actor',
            'bio.required' => 'Masukan Biodata',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'massage' => 'Silahkan isi dengan benar!',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $actor = Actor::find($id);
            $actor->nama_actor = $request->nama_actor;
            $actor->bio = $request->bio;
            $actor->save();
        }

        if ($actor) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ], 200);
        } else {
            return response()->json([
                'succes' => false,
                'message' => 'Data gagal disimpan',
            ], 400);
        }
    }

    public function destroy($id) {
        $actor = Actor::find($id);
        if($actor) {
            $actor->delete();
            return response()->json([
            'success' => true,
            'message' => 'data'.$actor->nama_actor.'data berhasil dihapus',
        ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ditemukan',
            ], 404);
        }
    }
}
