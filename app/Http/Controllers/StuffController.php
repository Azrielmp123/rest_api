<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Stuff;
use Illuminate\Http\Request;

class StuffController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $data = Stuff::with('stuffStock')->get();
            
            return ApiFormatter::sendResponse(200, 'success', $data);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
             //validasi
             //'nama_colum' => 'validasi'
            $this->validate($request, [
                'name' => 'required',
                'category' => 'required',
            ]);

            $prosesData = Stuff::create([
                'name' => $request->name,
                'category' => $request->category,
            ]);

            if ($prosesData) {
                return ApiFormatter::sendResponse(200, 'success', $prosesData);
            } else {
                return ApiFormatter::sendResponse(400, 'bad request', 'Gagal memproses data stuff!
                 Silahkan coba lagi.');
            }
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }

    }
    public function show($id)
    {
        try{
           $data = Stuff::where('id',$id)->first();
           // first()       : kalau gada, tetep success data kosong
           // firstOrFail() : kalau gada, munculnya error
           // find()        : mencari berdasarkan primary key
           // where()       : mencari colum spesific tertentu

             return ApiFormatter::sendResponse(200,'success', $data);
         }catch (\Exception $err){
            return ApiFormatter::sendResponse(400, 'bad request',$err->getMessage());
     }

  }


  public function update ( Request $request, $id )
  {
    try{
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
    ]);
   
        $checkProses = Stuff::where('id', $id)->update([
          //menghasilkan data yang ditambah
            'name' => $request->name,
            'category' => $request->category,
    ]);

        if($checkProses) {
             $data = Stuff::where('id', $id)->first();
             return ApiFormatter::sendResponse(200, 'success', $data);
       }
       }catch (\Exception $err) {
             return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
      }

   }
          public function destroy($id)
          {
            try{
              $checkProsess = Stuff::where('id', $id)->delete();
              
              if($checkProsess){
                return ApiFormatter::sendResponse(200, 'success','Berhasil Menghapus data stuff!');
              }
              }catch (\Exception $err){
                return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
              }
              
            }

            public function trash()
            {
                try {
                $data = Stuff::onlyTrashed()->get();
        
                return 
                ApiFormatter::sendResponse(200, 'succes', 'Berhasil hapus data stuff');
                } catch (\Exception $err) {
                    return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
                }
            }

            public function restore($id)
            {
                try {
                    $checkRestore = Stuff::onlyTrashed()->restore();
            
                    if ($checkRestore) {
                        $data = Stuff::where('id', $id)->first();
                        return ApiFormatter::sendResponse(200, 'success', $data);
                    }
                } catch (\Exception $err) {
                    return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
                }
            }
            public function permanentDelete($id)
             {
               try {
                     $checkPermanentDelete = Stuff::onlyTrashed()->where('id',$id)->forceDelete();

                    if ($checkPermanentDelete) {
                    return ApiFormatter::sendResponse(200, 'success', 'Berhasil Menghapus permanent data stuff!');
                    }

                    }catch (\Exception $err) {
                    return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
       }
    }
        
}
        
    
          

          
        

