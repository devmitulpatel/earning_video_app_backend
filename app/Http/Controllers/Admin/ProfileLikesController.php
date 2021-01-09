<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProfileLikeRequest;
use App\Http\Requests\StoreProfileLikeRequest;
use App\Http\Requests\UpdateProfileLikeRequest;
use App\Models\ProfileLike;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProfileLikesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('profile_like_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ProfileLike::with(['profile_by', 'like_bies'])->select(sprintf('%s.*', (new ProfileLike)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'profile_like_show';
                $editGate      = 'profile_like_edit';
                $deleteGate    = 'profile_like_delete';
                $crudRoutePart = 'profile-likes';

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
            $table->addColumn('profile_by_name', function ($row) {
                return $row->profile_by ? $row->profile_by->name : '';
            });

            $table->editColumn('like_by', function ($row) {
                $labels = [];

                foreach ($row->like_bies as $like_by) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $like_by->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'profile_by', 'like_by']);

            return $table->make(true);
        }

        return view('admin.profileLikes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('profile_like_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profile_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $like_bies = User::all()->pluck('name', 'id');

        return view('admin.profileLikes.create', compact('profile_bies', 'like_bies'));
    }

    public function store(StoreProfileLikeRequest $request)
    {
        $profileLike = ProfileLike::create($request->all());
        $profileLike->like_bies()->sync($request->input('like_bies', []));

        return redirect()->route('admin.profile-likes.index');
    }

    public function edit(ProfileLike $profileLike)
    {
        abort_if(Gate::denies('profile_like_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profile_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $like_bies = User::all()->pluck('name', 'id');

        $profileLike->load('profile_by', 'like_bies');

        return view('admin.profileLikes.edit', compact('profile_bies', 'like_bies', 'profileLike'));
    }

    public function update(UpdateProfileLikeRequest $request, ProfileLike $profileLike)
    {
        $profileLike->update($request->all());
        $profileLike->like_bies()->sync($request->input('like_bies', []));

        return redirect()->route('admin.profile-likes.index');
    }

    public function show(ProfileLike $profileLike)
    {
        abort_if(Gate::denies('profile_like_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profileLike->load('profile_by', 'like_bies');

        return view('admin.profileLikes.show', compact('profileLike'));
    }

    public function destroy(ProfileLike $profileLike)
    {
        abort_if(Gate::denies('profile_like_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profileLike->delete();

        return back();
    }

    public function massDestroy(MassDestroyProfileLikeRequest $request)
    {
        ProfileLike::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
