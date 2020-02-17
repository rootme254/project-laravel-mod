<?php

namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
class MediaApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if( !$request->hasFile('avatar') )
        return response()->json(['Message'=>'No file attached'],400);
     
      $file = $request->file('avatar');
      $title = !is_null($request->title) ? $request->title : env('DEFAULT_UPLOADED_FILE_NAME','Uploaded file');
      $folder = !is_null($request->store_in_folder) ? $request->store_in_folder : env('DEFAULT_STORAGE_FOLDER_UPLOADED_FILE','Files');
      $duration = !is_null($request->duration) ? $request->duration : null;
      $disk = !is_null($request->store_in_disk) ? $request->store_in_disk : env('FILESYSTEM_DRIVER','public');
      $mimeType = $file->getClientMimeType();
      $extension = $file->getClientOriginalExtension();
      $size = $file->getSize();
      $fileName = $title.'-'.Carbon::now().'.'.$file->getClientOriginalExtension();
      $path = $file->storeAs($folder,$fileName,$disk);
      $public_uri =asset('storage/'.$path);
      $local_path = storage_path($path);

      $data = [
          'title' => $title,
          'mimeType' =>$mimeType,
          'extension' => $extension,
          'size' => $size,
          'duration' => $duration,
          'public_uri' => $public_uri,
          'local_path' => $local_path,
      ];
      
       $media = Media::create($data);
       return response()->json($media,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(media $media)
    {
        //
    }

    
}
