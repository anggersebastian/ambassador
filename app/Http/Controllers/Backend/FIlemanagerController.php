<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AwsSdk\S3Service;

class FilemanagerController extends Controller{

    public function index(Request $request)
    {
        $aws = new S3Service();
        $object = $aws->listObject('dropy-product');

        return response()->json($object);
    }

    public function upload(Request $request)
    {
        if($request->hasFile('file')){
            $s3    = new S3Service();
            $imagePacking   = $request->file('file');
            try{
                $uploadFile  = $s3->putObject($imagePacking, $imagePacking->getClientOriginalName(), $imagePacking->getMimeType(),'dropy-product');
            }catch (\Exception $exception){
                $uploadFile  = $exception->getMessage();
            }

            return response()->json([
                'status' => true,
                'data' => 'dropy-product/'.$uploadFile['name']
            ]);
        }
    }

    

}