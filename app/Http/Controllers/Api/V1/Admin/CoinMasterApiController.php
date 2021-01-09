<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoinMasterRequest;
use App\Http\Requests\UpdateCoinMasterRequest;
use App\Http\Resources\Admin\CoinMasterResource;
use App\Models\CoinMaster;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoinMasterApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('coin_master_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CoinMasterResource(CoinMaster::with(['user', 'task'])->get());
    }

    public function store(StoreCoinMasterRequest $request)
    {
        $coinMaster = CoinMaster::create($request->all());

        return (new CoinMasterResource($coinMaster))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CoinMaster $coinMaster)
    {
        abort_if(Gate::denies('coin_master_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CoinMasterResource($coinMaster->load(['user', 'task']));
    }

    public function update(UpdateCoinMasterRequest $request, CoinMaster $coinMaster)
    {
        $coinMaster->update($request->all());

        return (new CoinMasterResource($coinMaster))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CoinMaster $coinMaster)
    {
        abort_if(Gate::denies('coin_master_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coinMaster->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
