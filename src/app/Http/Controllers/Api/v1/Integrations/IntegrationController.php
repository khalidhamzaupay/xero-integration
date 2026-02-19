<?php

namespace App\Http\Controllers\Api\v1\Integrations;

use App\Enums\IntegrationsType;
use App\Factories\IntegrationPaymentMethodFactory;
use App\Http\Controllers\ApplicationController;
use App\Http\Requests\Configrations\GetPaymentMethodsForThirdPartyAccessFormRequest;
use App\Http\Requests\Configrations\MapPaymentMethodForThirdPartyAccessFormRequest;
use App\Http\Requests\XeroCallbackFormRequest;
use App\Http\Resources\ThirdPartyAccess\ThirdPartyAccessResource;
use App\Models\Integrations\ThirdPartyAccess;
use App\Models\Integrations\ThirdPartyMapping;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Services\ThirdPartyAccess\Authentication\HandleXeroCallbackService;
use App\Traits\Responder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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



    public function getMerchantIntegrationPaymentMethodConfigurations(Request $request, $merchant_id, string $integrationSlug)
    {
        $thirdPartyAccess = ThirdPartyAccess::where('merchant_id', $merchant_id)->where('type', $integrationSlug)->first();
        if ($thirdPartyAccess) {
            $configurations = IntegrationPaymentMethodFactory::make($integrationSlug)->get($thirdPartyAccess) ?? [];
            $params = [
                "data" => [
                        "title" => 'show-all payment methods mapping',
                        "alias" => $this->moduleAlias,
                        "third_party_access" => new ThirdPartyAccessResource($thirdPartyAccess),
                    ] + $configurations,
                "view" => "{$this->moduleAlias}::{$this->viewPath}.show"
            ];
        } else {
            $params = [
                "data" => ["message" => "No integration found"],
                "response_code" => 422,
                "redirectBack" => true
            ];
        }
        return $this->response($params);
    }

    public function storePaymentTypeMappingForIntegration(MapPaymentMethodForThirdPartyAccessFormRequest $request, $merchant_id,string $integrationSlug)
    {
        $thirdPartyAccess = ThirdPartyAccess::where('merchant_id', $merchant_id)->where('type', $integrationSlug)->first();
        if ($thirdPartyAccess) {
            $paymentMethodsMappingData = $request->validated();
            foreach ($paymentMethodsMappingData as $paymentMethodMappingData) {
                $paymentMethodMappingData = $paymentMethodMappingData + ['object_type' => PaymentMethod::class, 'merchant_id' => $merchant_id, 'type' => $integrationSlug];
                ThirdPartyMapping::updateOrCreate(Arr::only($paymentMethodMappingData, 'object_id'), $paymentMethodMappingData);
            }
            $configurations = IntegrationPaymentMethodFactory::make($integrationSlug)->get($thirdPartyAccess);
            $params = [
                "data" => [
                        "title" =>  'show-all payment methods mapping',
                        "alias" => $this->moduleAlias,
                        "third_party_access" => new ThirdPartyAccessResource($thirdPartyAccess),
                    ] + $configurations,
                "view" => "{$this->moduleAlias}::{$this->viewPath}.show"
            ];
        } else {
            $params = [
                "data" => ["message" => "No integration found"],
                "response_code" => 422,
                "redirectBack" => true
            ];
        }
        return $this->response($params);
    }
}
