<?php

namespace App\Http\Controllers\Api\v1\Integrations;

use App\Enums\IntegrationsType;
use App\Http\Controllers\ApplicationController;
use App\Http\Requests\XeroCallbackFormRequest;
use App\Models\Integrations\ThirdPartyAccess;
use App\Services\ThirdPartyAccess\Authentication\HandleXeroCallbackService;
use App\Traits\Responder;

/**
 * Class IntegrationController
 */
class IntegrationController extends ApplicationController
{
    use Responder;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'Integration';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'Integration';

    /**
     * Module Alias.
     *
     * @var string
     */
    protected $moduleAlias = 'Integrations';

    public function __construct()
    {
        parent::__construct();

    }

    public function xeroHandleCallback(XeroCallbackFormRequest $request)
    {
        $callbackResponse = $request->validated();
        $code = $callbackResponse['code'];
        $thirdPartyAccess = ThirdPartyAccess::find($callbackResponse['state']);
        try {
            $service = new HandleXeroCallbackService($code,$thirdPartyAccess);
            $result = $service->handle();

            return response()->json($result);

        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
