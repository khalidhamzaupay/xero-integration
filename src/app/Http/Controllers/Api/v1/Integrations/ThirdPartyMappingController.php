<?php

namespace App\Http\Controllers\Api\v1\Integrations;

use App\Http\Controllers\ApplicationController;
use App\Http\Resources\ThirdPartyMapping\ThirdPartyMappingResource;
use App\Models\Integrations\ThirdPartyMapping;
use Illuminate\Http\Request;

class ThirdPartyMappingController extends ApplicationController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,$merchant_id)
    {
        $query = ThirdPartyMapping::where('merchant_id', $merchant_id)->with(['object']);;
        foreach (ThirdPartyMapping::$allowedFilersExact as $filter) {
            if ($request->has($filter)) {
                $query->where($filter, $request->get($filter));
            }
        }
        foreach (ThirdPartyMapping::$allowedFilters as $filter) {
            if ($request->has($filter)) {
                $query->where($filter, 'LIKE', '%' . $request->get($filter) . '%');
            }
        }
        $sortField = $request->get('sort', 'created_at'); // Default sort
        $direction = $request->get('direction', 'desc');

        if (in_array($sortField, ThirdPartyMapping::$allowedSorts)) {
            $query->orderBy($sortField, $direction);
        }

        return ThirdPartyMappingResource::collection($query->paginate($request->get('per_page', 15)));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ThirdPartyMapping $thirdPartyMapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ThirdPartyMapping $thirdPartyMapping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ThirdPartyMapping $thirdPartyMapping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThirdPartyMapping $thirdPartyMapping)
    {
        //
    }
}
