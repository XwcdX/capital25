<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CommodityController extends BaseController
{
    public function __construct(Commodity $model)
    {
        parent::__construct($model);
    }
    public function getAllCommodity()
    {
        return $this->model::get();
    }
}
