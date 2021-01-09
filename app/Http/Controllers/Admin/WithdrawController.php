<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWithdrawRequest;
use App\Http\Requests\StoreWithdrawRequest;
use App\Http\Requests\UpdateWithdrawRequest;
use App\Models\User;
use App\Models\Withdraw;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('withdraw_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Withdraw::with(['user', 'approved_by'])->select(sprintf('%s.*', (new Withdraw)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'withdraw_show';
                $editGate      = 'withdraw_edit';
                $deleteGate    = 'withdraw_delete';
                $crudRoutePart = 'withdraws';

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

            $table->editColumn('coin_amount', function ($row) {
                return $row->coin_amount ? $row->coin_amount : "";
            });
            $table->editColumn('rate', function ($row) {
                return $row->rate ? $row->rate : "";
            });
            $table->editColumn('inr_amount', function ($row) {
                return $row->inr_amount ? $row->inr_amount : "";
            });
            $table->addColumn('approved_by_name', function ($row) {
                return $row->approved_by ? $row->approved_by->name : '';
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? Withdraw::STATUS_RADIO[$row->status] : '';
            });
            $table->editColumn('transaction', function ($row) {
                return $row->transaction ? $row->transaction : "";
            });
            $table->editColumn('transaction_data', function ($row) {
                return $row->transaction_data ? $row->transaction_data : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'approved_by']);

            return $table->make(true);
        }

        return view('admin.withdraws.index');
    }

    public function create()
    {
        abort_if(Gate::denies('withdraw_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $approved_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.withdraws.create', compact('users', 'approved_bies'));
    }

    public function store(StoreWithdrawRequest $request)
    {
        $withdraw = Withdraw::create($request->all());

        return redirect()->route('admin.withdraws.index');
    }

    public function edit(Withdraw $withdraw)
    {
        abort_if(Gate::denies('withdraw_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $approved_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $withdraw->load('user', 'approved_by');

        return view('admin.withdraws.edit', compact('users', 'approved_bies', 'withdraw'));
    }

    public function update(UpdateWithdrawRequest $request, Withdraw $withdraw)
    {
        $withdraw->update($request->all());

        return redirect()->route('admin.withdraws.index');
    }

    public function show(Withdraw $withdraw)
    {
        abort_if(Gate::denies('withdraw_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $withdraw->load('user', 'approved_by');

        return view('admin.withdraws.show', compact('withdraw'));
    }

    public function destroy(Withdraw $withdraw)
    {
        abort_if(Gate::denies('withdraw_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $withdraw->delete();

        return back();
    }

    public function massDestroy(MassDestroyWithdrawRequest $request)
    {
        Withdraw::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
