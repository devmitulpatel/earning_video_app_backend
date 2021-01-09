<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCoinTaskRequest;
use App\Http\Requests\StoreCoinTaskRequest;
use App\Http\Requests\UpdateCoinTaskRequest;
use App\Models\CoinTask;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CoinTaskController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('coin_task_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CoinTask::with(['task_finished_bies'])->select(sprintf('%s.*', (new CoinTask)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'coin_task_show';
                $editGate      = 'coin_task_edit';
                $deleteGate    = 'coin_task_delete';
                $crudRoutePart = 'coin-tasks';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('coin_earn', function ($row) {
                return $row->coin_earn ? $row->coin_earn : "";
            });
            $table->editColumn('single_task', function ($row) {
                return $row->single_task ? CoinTask::SINGLE_TASK_RADIO[$row->single_task] : '';
            });
            $table->editColumn('task_finished_by', function ($row) {
                $labels = [];

                foreach ($row->task_finished_bies as $task_finished_by) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $task_finished_by->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'task_finished_by']);

            return $table->make(true);
        }

        return view('admin.coinTasks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('coin_task_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $task_finished_bies = User::all()->pluck('name', 'id');

        return view('admin.coinTasks.create', compact('task_finished_bies'));
    }

    public function store(StoreCoinTaskRequest $request)
    {
        $coinTask = CoinTask::create($request->all());
        $coinTask->task_finished_bies()->sync($request->input('task_finished_bies', []));

        return redirect()->route('admin.coin-tasks.index');
    }

    public function edit(CoinTask $coinTask)
    {
        abort_if(Gate::denies('coin_task_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $task_finished_bies = User::all()->pluck('name', 'id');

        $coinTask->load('task_finished_bies');

        return view('admin.coinTasks.edit', compact('task_finished_bies', 'coinTask'));
    }

    public function update(UpdateCoinTaskRequest $request, CoinTask $coinTask)
    {
        $coinTask->update($request->all());
        $coinTask->task_finished_bies()->sync($request->input('task_finished_bies', []));

        return redirect()->route('admin.coin-tasks.index');
    }

    public function show(CoinTask $coinTask)
    {
        abort_if(Gate::denies('coin_task_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coinTask->load('task_finished_bies');

        return view('admin.coinTasks.show', compact('coinTask'));
    }

    public function destroy(CoinTask $coinTask)
    {
        abort_if(Gate::denies('coin_task_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coinTask->delete();

        return back();
    }

    public function massDestroy(MassDestroyCoinTaskRequest $request)
    {
        CoinTask::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
