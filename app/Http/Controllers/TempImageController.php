<?php

namespace App\Http\Controllers;

use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TempImageController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'please fix the error',
                'errors' => $validator->errors()
            ]);
        }

        //upload image here

        $image = $request->image;

        $ext = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;

        //store image info in database

        $tempImage = new TempImage();
        $tempImage->name = $imageName;
        $tempImage->save();

        //move image in temp dir

        $image->move(public_path('uploads\temp'), $imageName);

        //success return

        return response()->json([
            'status' => true,
            'message' => 'image saved successfully',
            'image' => $tempImage
        ]);

    }
}
