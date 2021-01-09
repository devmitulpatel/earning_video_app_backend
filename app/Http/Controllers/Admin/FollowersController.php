<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFollowerRequest;
use App\Http\Requests\StoreFollowerRequest;
use App\Http\Requests\UpdateFollowerRequest;
use App\Models\Follower;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FollowersController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('follower_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Follower::with(['host', 'followers'])->select(sprintf('%s.*', (new Follower)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'follower_show';
                $editGate      = 'follower_edit';
                $deleteGate    = 'follower_delete';
                $crudRoutePart = 'followers';

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
            $table->addColumn('host_name', function ($row) {
                return $row->host ? $row->host->name : '';
            });

            $table->editColumn('host.email', function ($row) {
                return $row->host ? (is_string($row->host) ? $row->host : $row->host->email) : '';
            });
            $table->editColumn('followers', function ($row) {
                $labels = [];

                foreach ($row->followers as $follower) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $follower->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'host', 'followers']);

            return $table->make(true);
        }

        return view('admin.followers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('follower_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hosts = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $followers = User::all()->pluck('name', 'id');

        return view('admin.followers.create', compact('hosts', 'followers'));
    }

    public function store(StoreFollowerRequest $request)
    {
        $follower = Follower::create($request->all());
        $follower->followers()->sync($request->input('followers', []));

        return redirect()->route('admin.followers.index');
    }

    public function edit(Follower $follower)
    {
        abort_if(Gate::denies('follower_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hosts = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $followers = User::all()->pluck('name', 'id');

        $follower->load('host', 'followers');

        return view('admin.followers.edit', compact('hosts', 'followers', 'follower'));
    }

    public function update(UpdateFollowerRequest $request, Follower $follower)
    {
        $follower->update($request->all());
        $follower->followers()->sync($request->input('followers', []));

        return redirect()->route('admin.followers.index');
    }

    public function show(Follower $follower)
    {
        abort_if(Gate::denies('follower_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follower->load('host', 'followers');

        return view('admin.followers.show', compact('follower'));
    }

    public function destroy(Follower $follower)
    {
        abort_if(Gate::denies('follower_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follower->delete();

        return back();
    }

    public function massDestroy(MassDestroyFollowerRequest $request)
    {
        Follower::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
