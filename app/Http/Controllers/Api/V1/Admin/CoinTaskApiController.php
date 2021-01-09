<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoinTaskRequest;
use App\Http\Requests\UpdateCoinTaskRequest;
use App\Http\Resources\Admin\CoinTaskResource;
use App\Models\CoinTask;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoinTaskApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('coin_task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CoinTaskResource(CoinTask::with(['task_finished_bies'])->get());
    }

    public function store(StoreCoinTaskRequest $request)
    {
        $coinTask = CoinTask::create($request->all());
        $coinTask->task_finished_bies()->sync($request->input('task_finished_bies', []));

        return (new CoinTaskResource($coinTask))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CoinTask $coinTask)
    {
        abort_if(Gate::denies('coin_task_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CoinTaskResource($coinTask->load(['task_finished_bies']));
    }

    public function update(UpdateCoinTaskRequest $request, CoinTask $coinTask)
    {
        $coinTask->update($request->all());
        $coinTask->task_finished_bies()->sync($request->input('task_finished_bies', []));

        return (new CoinTaskResource($coinTask))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CoinTask $coinTask)
    {
        abort_if(Gate::denies('coin_task_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coinTask->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
