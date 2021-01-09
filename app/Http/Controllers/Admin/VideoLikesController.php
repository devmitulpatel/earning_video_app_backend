<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVideoLikeRequest;
use App\Http\Requests\StoreVideoLikeRequest;
use App\Http\Requests\UpdateVideoLikeRequest;
use App\Models\User;
use App\Models\VideoLike;
use App\Models\VideoList;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VideoLikesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('video_like_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VideoLike::with(['video', 'like_bies'])->select(sprintf('%s.*', (new VideoLike)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'video_like_show';
                $editGate      = 'video_like_edit';
                $deleteGate    = 'video_like_delete';
                $crudRoutePart = 'video-likes';

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
            $table->addColumn('video_name', function ($row) {
                return $row->video ? $row->video->name : '';
            });

            $table->editColumn('like_by', function ($row) {
                $labels = [];

                foreach ($row->like_bies as $like_by) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $like_by->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'video', 'like_by']);

            return $table->make(true);
        }

        return view('admin.videoLikes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('video_like_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = VideoList::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $like_bies = User::all()->pluck('name', 'id');

        return view('admin.videoLikes.create', compact('videos', 'like_bies'));
    }

    public function store(StoreVideoLikeRequest $request)
    {
        $videoLike = VideoLike::create($request->all());
        $videoLike->like_bies()->sync($request->input('like_bies', []));

        return redirect()->route('admin.video-likes.index');
    }

    public function edit(VideoLike $videoLike)
    {
        abort_if(Gate::denies('video_like_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = VideoList::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $like_bies = User::all()->pluck('name', 'id');

        $videoLike->load('video', 'like_bies');

        return view('admin.videoLikes.edit', compact('videos', 'like_bies', 'videoLike'));
    }

    public function update(UpdateVideoLikeRequest $request, VideoLike $videoLike)
    {
        $videoLike->update($request->all());
        $videoLike->like_bies()->sync($request->input('like_bies', []));

        return redirect()->route('admin.video-likes.index');
    }

    public function show(VideoLike $videoLike)
    {
        abort_if(Gate::denies('video_like_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videoLike->load('video', 'like_bies');

        return view('admin.videoLikes.show', compact('videoLike'));
    }

    public function destroy(VideoLike $videoLike)
    {
        abort_if(Gate::denies('video_like_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videoLike->delete();

        return back();
    }

    public function massDestroy(MassDestroyVideoLikeRequest $request)
    {
        VideoLike::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
