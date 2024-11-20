<?php

namespace App\Http\Controllers;

use App\Models\MyModel;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    // This method will return all blogs
    public function index()
    {
        $blogs = MyModel::orderBy('created_at','DESC')->get();
        return response()->json([
            'status' => true,
            'data' => $blogs
        ]);
    }

    // This method will return a single blog
    public function show($id)
    {
        $blog = MyModel::find($id);
        $blog['date'] = \Carbon\Carbon::parse($blog->created_at)->format('d M, Y');
        return response()->json([
            'status' => true,
            'data' => $blog
        ]);
    }

    // This method will insert blogs
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|min:10',
                'author' => 'required|min:3',
                'description' => 'nullable|string',
                'shortDes' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please fix the errors',
                    'errors' => $validator->errors()
                ], 400);
            }

            $blog = new MyModel();
            $blog->fill($request->only(['title', 'author', 'description', 'shortDec']));
            $blog->save();

            // save image here

            $tempImage = TempImage::find($request->image_id);

            if($tempImage!=null) {

                $imageExtArray = explode('.',$tempImage->name);
                $ext = last($imageExtArray);
                $imageName = time().'-'.$blog->id.'.'.$ext;

                $blog->image = $imageName;
                $blog->save();


                $sourcePath = public_path('uploads/temp/'.$tempImage->name);
                $destPath = public_path('uploads/blogs/'.$imageName);
                File::copy($sourcePath, $destPath);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data saved successfully',
                'data' => $blog
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }


    // This method will update blogs
    public function update()
    {

    }

    // This method will delete blogs
    public function destroy(int $id)
    {

    }
}
