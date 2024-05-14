<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\hash;
use App\Helpers\ApiFormatter;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{       
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    
        public function index()
        {
            try {
                $data = User::all()->toArray();
    
                return ApiFormatter::sendResponse(200, 'success', $data);
            } catch (\Exception $err) {
                return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
            }
        }
        public function store(Request $request)
    {
        try {
             
            $this->validate($request, [
                'username' => 'required|min:4|unique:users,username',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required'
            ]);

            $prosesData = User::create([   
                'username' => $request->username,
                'email' => $request->email,
                'password' => hash::make($request->password), 
                'role' => $request->role,
            ]);

            if ($prosesData) {
                return ApiFormatter::sendResponse(200, 'success', $prosesData);
            } else {
                return ApiFormatter::sendResponse(400, 'bad request', 'Gagal memproses data user!
                 Silahkan coba lagi.');
            }
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }

    }
    public function show($id)
    {
        try{
           $data = User::where('id',$id)->first();
           // first()       : kalau gada, tetep success data kosong
           // firstOrFail() : kalau gada, munculnya error
           // find()        : mencari berdasarkan primary key
           // where()       : mencari colum spesific tertentu

             return ApiFormatter::sendResponse(200,'success', $data);
         }catch (\Exception $err){
            return ApiFormatter::sendResponse(400, 'bad request',$err->getMessage());
     }


  }
  public function update(Request $request, $id)
  {
      try {
          $this->validate($request, [
              'username' => 'required|unique:users,username', $id,
              'email' => 'required|unique:users,email', $id,
              'password' => 'required',
              'role' => 'required'
          ]);

          $checkProses = User::where('id', $id)->update([
              'username' => $request->username,
              'email' => $request->email,
              'password' => $request->password,
              'role' => $request->role
          ]);

          if ($checkProses) {
              $data = User::where('id', $id)->first();

              return ApiFormatter::sendResponse(200, 'success', $data);
          }
      } catch (\Exception $err) {
          return ApiFormatter::sendResponse(400, 'bad request', $err->getmessage());
      }
  }

  public function destroy($id)
  {
      try {
          $checkproses = User::where('id', $id)->delete();

          if ($checkproses) {
              return
                  ApiFormatter::sendResponse(200, 'succes', 'berhasil hapus data User!');
          }
      } catch (\Exception $err) {
          return
              ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
      }
  }

  public function trash()
  {
      try {
          $data = User::onlyTrashed()->get();

          return
              ApiFormatter::sendResponse(200, 'succes', $data);
      } catch (\Exception $err) {
          return
              ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
      }
  }

  public function restore($id)
  {
      try {
          $checkRestore = User::onlyTrashed()->where('id',$id)->restore();

          if ($checkRestore) {
              $data = User::where('id', $id)->first();
              return ApiFormatter::sendResponse(200, 'succes', $data);
          }
      }catch (\Exception $err) {
          return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
      }
  }

  public function permanentDelete($id)
  {
      try {
          $checkpermanentDelete = User::onlyTrashed()->where('id', $id)->forceDelete();

          if ($checkpermanentDelete) {
              return ApiFormatter::sendResponse(200, 'succes', 'berhasil menghapus permanen data User!');
          }
      } catch (\Exception $err) {
          return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
      }
  }
}

        
