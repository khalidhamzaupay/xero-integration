<?php

namespace App\Http\Controllers\Api\v1\Integrations;

use App\Http\Controllers\ApplicationController;
use App\Http\Requests\ThirdPartyAccess\ThirdPartyAccessStoreFormRequest;
use App\Http\Requests\ThirdPartyAccess\ThirdPartyAccessUpdateFormRequest;
use App\Http\Resources\ThirdPartyAccess\ThirdPartyAccessResource;
use app\Models\Integrations\ThirdPartyAccess;
use App\Services\ThirdPartyAccess\StoreThirdPartyAccessService;
use App\Traits\Responder;
use Illuminate\Http\Request;

class ThirdPartyAccessController extends ApplicationController
{
    use Responder;
    protected $viewPath = 'ThirdPartyAccess';
    protected $resourceRoute = 'ThirdPartyAccess';
    protected $moduleAlias = 'Integrations';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(ThirdPartyAccessStoreFormRequest $request, StoreThirdPartyAccessService $service)
    {
        try {
            $response = $service->handle($request->validated());
            if (is_array($response)) {
                $prams = [
                    "data" => [
                            "title" => __('main.show-all') . ' ' . __('main.ThirdPartyAccess'),
                            "alias" => $this->moduleAlias,
                        ] + $response,
                    "redirectTo" => ["route" => "{$this->resourceRoute}.show", "args" => [$response['third_party_access']->id]]
                ];
            } else if (get_class($response) == ThirdPartyAccess::class) {
                $prams = [
                    "data" => [
                        "title" => __('main.show-all') . ' ' . __('main.ThirdPartyAccess'),
                        "alias" => $this->moduleAlias,
                        "thirdPartyAccess" => new ThirdPartyAccessResource($response)
                    ],
                    "redirectTo" => ["route" => "{$this->resourceRoute}.show", "args" => [$response->id]]
                ];
            }

        } catch (\Exception $exception) {
            $prams = [
                "data" => ["message" => "Something went wrong: " . $exception->getMessage()],
                "response_code" => 422,
                "redirectBack" => true
            ];
        }
        return $this->response($prams);
    }

    /**
     * Display the specified resource.
     */
    public function show(ThirdPartyAccess $thirdPartyAccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ThirdPartyAccess $thirdPartyAccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ThirdPartyAccessUpdateFormRequest $request, ThirdPartyAccess $thirdPartyAccess,UpdateThirdPartyAccessService $updateThirdPartyAccessService)
    {
        try {
            $response = $updateThirdPartyAccessService->handle($thirdPartyAccess,$request->validated());
            if (is_array($response)) {
                $prams = [
                    "data" => [
                            "title" => __('main.show-all') . ' ' . __('main.ThirdPartyAccess'),
                            "alias" => $this->moduleAlias,
                        ] + $response,
                    "redirectTo" => ["route" => "{$this->resourceRoute}.show", "args" => [$response['third_party_access']->id]]
                ];
            } else if (get_class($response) == ThirdPartyAccess::class) {
                $prams = [
                    "data" => [
                        "title" => __('main.show-all') . ' ' . __('main.ThirdPartyAccess'),
                        "alias" => $this->moduleAlias,
                        "thirdPartyAccess" => new ThirdPartyAccessResource($response)
                    ],
                    "redirectTo" => ["route" => "{$this->resourceRoute}.show", "args" => [$response->id]]
                ];
            }

        } catch (\Exception $exception) {
            $prams = [
                "data" => ["message" => "Something went wrong: " . $exception->getMessage()],
                "response_code" => 422,
                "redirectBack" => true
            ];
        }
        return $this->response($prams);
    }


    public function secondTimeSetup(ThirdPartyAccessUpdateFormRequest $request, $id,SecondTimeSetupThirdPartyAccessService $secondTimeSetupThirdPartyAccessService)
    {
        $thirdPartyAccess = ThirdPartyAccess::find($id);
        try {
            $response = $secondTimeSetupThirdPartyAccessService->handle($thirdPartyAccess,$request->validated());
            if (is_array($response)) {
                $prams = [
                    "data" => [
                            "title" => __('main.show-all') . ' ' . __('main.ThirdPartyAccess'),
                            "alias" => $this->moduleAlias,
                        ] + $response,
                    "redirectTo" => ["route" => "{$this->resourceRoute}.show", "args" => [$response['third_party_access']->id]]
                ];
            } else if (get_class($response) == ThirdPartyAccess::class) {
                $prams = [
                    "data" => [
                        "title" => __('main.show-all') . ' ' . __('main.ThirdPartyAccess'),
                        "alias" => $this->moduleAlias,
                        "thirdPartyAccess" => new ThirdPartyAccessResource($response)
                    ],
                    "redirectTo" => ["route" => "{$this->resourceRoute}.show", "args" => [$response->id]]
                ];
            }

        } catch (\Exception $exception) {
            $prams = [
                "data" => ["message" => "Something went wrong: " . $exception->getMessage()],
                "response_code" => 422,
                "redirectBack" => true
            ];
        }
        return $this->response($prams);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThirdPartyAccess $thirdPartyAccess)
    {
        //
    }
}
