<?php

namespace App\Http\Controllers;

use App\Models\FileStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files=FileStorage::where('user_id',Auth::id())->paginate(5);
        return view('upload.index',compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'required'
        ]);
        $input=$request->all();

        $file=$request->file('file_name');
        $fileName=time().'_'.$file->getClientOriginalName();
        $file->move(public_path('upload'),$fileName);
        $input['name']=$fileName;
        $input['path']=Str::random(4);

        if($request->access){
          $input['access']=1;
        }

        $input['user_id']=Auth::id();
        FileStorage::create($input);

        return redirect()->route('upload.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileStorage  $fileStorage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file=FileStorage::findOrFail($id);
        $fileName=$file->name;
        $file->delete();
        File::delete(public_path('upload/'.$fileName));

        return redirect()->back()->with('msg','File Deleted');
    }

    public function path($path)
    {
        $link=FileStorage::where('path',$path)->first();
        $file=public_path('upload/'.$link->name);
        if($link->access==true || Auth::id()==$link->user_id){
            return response()->download($file);
        }
        else{
            return abort(403);
        }
    }
}
