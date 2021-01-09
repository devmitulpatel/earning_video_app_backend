<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCoinMasterRequest;
use App\Http\Requests\StoreCoinMasterRequest;
use App\Http\Requests\UpdateCoinMasterRequest;
use App\Models\CoinMaster;
use App\Models\CoinTask;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CoinMasterController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('coin_master_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CoinMaster::with(['user', 'task'])->select(sprintf('%s.*', (new CoinMaster)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'coin_master_show';
                $editGate      = 'coin_master_edit';
                $deleteGate    = 'coin_master_delete';
                $crudRoutePart = 'coin-masters';

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
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('task_name', function ($row) {
                return $row->task ? $row->task->name : '';
            });

            $table->editColumn('task.coin_earn', function ($row) {
                return $row->task ? (is_string($row->task) ? $row->task : $row->task->coin_earn) : '';
            });
            $table->editColumn('coin_amount', function ($row) {
                return $row->coin_amount ? $row->coin_amount : "";
            });
            $table->editColumn('type_transaction', function ($row) {
                return $row->type_transaction ? CoinMaster::TYPE_TRANSACTION_RADIO[$row->type_transaction] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'task']);

            return $table->make(true);
        }

        return view('admin.coinMasters.index');
    }

    public function create()
    {
        abort_if(Gate::denies('coin_master_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tasks = CoinTask::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.coinMasters.create', compact('users', 'tasks'));
    }

    public function store(StoreCoinMasterRequest $request)
    {
        $coinMaster = CoinMaster::create($request->all());

        return redirect()->route('admin.coin-masters.index');
    }

    public function edit(CoinMaster $coinMaster)
    {
        abort_if(Gate::denies('coin_master_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tasks = CoinTask::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coinMaster->load('user', 'task');

        return view('admin.coinMasters.edit', compact('users', 'tasks', 'coinMaster'));
    }

    public function update(UpdateCoinMasterRequest $request, CoinMaster $coinMaster)
    {
        $coinMaster->update($request->all());

        return redirect()->route('admin.coin-masters.index');
    }

    public function show(CoinMaster $coinMaster)
    {
        abort_if(Gate::denies('coin_master_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coinMaster->load('user', 'task');

        return view('admin.coinMasters.show', compact('coinMaster'));
    }

    public function destroy(CoinMaster $coinMaster)
    {
        abort_if(Gate::denies('coin_master_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coinMaster->delete();

        return back();
    }

    public function massDestroy(MassDestroyCoinMasterRequest $request)
    {
        CoinMaster::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
