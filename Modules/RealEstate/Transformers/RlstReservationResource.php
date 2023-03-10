<?php

namespace Modules\RealEstate\Transformers;

use App\Http\Resources\Salesman\SalesmanResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\RecievablePayable\Transformers\RpInstallmentPaymentPlanResource;

class RlstReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "date" => $this->date,
            "salesman" => new SalesmanResource($this->salesman),
            "customer" => new RlstCustomerResource($this->customer),
            "payment_plan_id" => $this->payment_plan_id,
            "paymentPlan" => @new \Modules\RecievablePayable\Transformers\RpInstallmentPaymentPlanResource($this->paymentPlan),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
