<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function uploadImageCloud(Request $request)
    {
        if(!$request->hasFile('images')){
            return response([
                'message' => 'Images file required.'
            ], 400);
        }
        $allowedfileExtension=['jpeg','jpg','png'];
        $images = [];
        if(is_array($request->file('images'))){
            foreach($request->file('images') as $file){
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if($check){
                    $uploadedFileUrl = cloudinary()->upload($file->getRealPath(), ['folder'=>'wsb-laravel'])->getSecurePath();
                    $images[] = $uploadedFileUrl;
                }else{
                    return response([
                        'message' => 'Invalid file format.'
                    ], 422);
                }
            }
        }else{
            $extension = $request->file('images')->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            if($check){
                $uploadedFileUrl = cloudinary()->upload($request->file('images')->getRealPath(), ['folder'=>'wsb-laravel'])->getSecurePath();
                $images[] = $uploadedFileUrl;
            }else{
                return response([
                    'message' => 'Invalid file format.'
                ], 422);
            }
        }
        return response([
            'images' => $images
        ], 200);
    }
}
