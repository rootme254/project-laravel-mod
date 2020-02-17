<?php

namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use App\Listing;
use Illuminate\Http\Request;
use App\Http\Requests\StoreListing;

class ListingApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listings = Listing::paginate(env('API_PAGINATE_NUM',10));
        return response()->json($listings,200);
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
    public function store(StoreListing $request)
    {
        $listing = Listing::create($request->all());
        return response()->json($listing,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $listing = Listing::find($id);

        if( is_null($listing) )
          return response()->json(['Message'=>'Record not found'],404);

        return response()->json($listing,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $listing = Listing::find($id);

        if( is_null($listing) )
          return response()->json(['Message'=>'Record not found'],404);

        $listing->update($request->all());
        return response()->json($listing,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $listing = Listing::find($id);

      if( is_null($listing) )
        return response()->json(['Message'=>'Record not found'],404);

      $listing->delete();

      return response()->json(null,204);
    }
}
