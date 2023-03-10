<?php

namespace App\Repositories\GeneralCustomer;

use App\Models\GeneralCustomer;
use App\Models\UserSettingScreen;
use App\Traits\CustomTableTrait;
use Illuminate\Support\Facades\DB;

class GeneralCustomerRepository implements GeneralCustomerRepositoryInterface
{

    private $model;
    private $setting;

    public function __construct(GeneralCustomer $model, UserSettingScreen $setting)
    {
        $this->model = $model;
        $this->setting = $setting;
    }

    public function all($request)
    {
        $models = $this->model->filter($request)->orderBy($request->order ? $request->order : 'updated_at', $request->sort ? $request->sort : 'DESC')
        ->where(function ($q) use ($request){
           $q->when($request->opening_balance,function ($q) use ($request){
               $q->doesntHave('opening_balances');
           });
        });

        if ($request->per_page) {
            return ['data' => $models->paginate($request->per_page), 'paginate' => true];
        } else {
            return ['data' => $models->get(), 'paginate' => false];
        }
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        DB::transaction(function () use ($data) {
            $model = $this->model->create($data);
            cacheForget("GeneralCustomer");
        });
    }

    public function update($data, $id)
    {
        // DB::transaction(function () use ($id, $data) {
        //     $model = $this->model->find($id);
        //     $model->update($data);

        //     $this->forget($id);

        // });

        return DB::transaction(function () use ($id, $data) {
            $this->model->where("id", $id)->update($data->all());
            return $this->model->find($id);
        });

    }

    public function delete($id)
    {
        $model = $this->find($id);
        $this->forget($id);
        $model->delete();
    }



    public function setting($request)
    {

        DB::transaction(function () use ($request) {

            $model = $this->setting->where('user_id', $request['user_id'])->where('screen_id', $request['screen_id'])->first();

            $request['data_json'] = json_encode($request['data_json']);

            if (!$model) {
                $this->setting->create($request->all());
            } else {
                $model->update($request->all());
            }

        });
    }

    public function getSetting($user_id, $screen_id)
    {
        return $this->setting->where('user_id', $user_id)->where('screen_id', $screen_id)->first();
    }

    public function logs($id)
    {
        return $this->model->find($id)->activities()->orderBy('created_at', 'DESC')->get();
    }
    private function forget($id)
    {
        $keys = [
            "GeneralCustomer",
            "GeneralCustomer_" . $id,
        ];
        foreach ($keys as $key) {
            cacheForget($key);
        }

    }

}
