<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyChannelRequest;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;
use App\Models\Channel;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ChannelsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('channel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Channel::with(['user', 'followed_bies'])->select(sprintf('%s.*', (new Channel)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'channel_show';
                $editGate      = 'channel_edit';
                $deleteGate    = 'channel_delete';
                $crudRoutePart = 'channels';

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
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('followed_by', function ($row) {
                $labels = [];

                foreach ($row->followed_bies as $followed_by) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $followed_by->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'followed_by']);

            return $table->make(true);
        }

        return view('admin.channels.index');
    }

    public function create()
    {
        abort_if(Gate::denies('channel_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $followed_bies = User::all()->pluck('name', 'id');

        return view('admin.channels.create', compact('users', 'followed_bies'));
    }

    public function store(StoreChannelRequest $request)
    {
        $channel = Channel::create($request->all());
        $channel->followed_bies()->sync($request->input('followed_bies', []));

        return redirect()->route('admin.channels.index');
    }

    public function edit(Channel $channel)
    {
        abort_if(Gate::denies('channel_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $followed_bies = User::all()->pluck('name', 'id');

        $channel->load('user', 'followed_bies');

        return view('admin.channels.edit', compact('users', 'followed_bies', 'channel'));
    }

    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $channel->update($request->all());
        $channel->followed_bies()->sync($request->input('followed_bies', []));

        return redirect()->route('admin.channels.index');
    }

    public function show(Channel $channel)
    {
        abort_if(Gate::denies('channel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channel->load('user', 'followed_bies');

        return view('admin.channels.show', compact('channel'));
    }

    public function destroy(Channel $channel)
    {
        abort_if(Gate::denies('channel_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channel->delete();

        return back();
    }

    public function massDestroy(MassDestroyChannelRequest $request)
    {
        Channel::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
