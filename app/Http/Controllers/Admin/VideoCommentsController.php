<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVideoCommentRequest;
use App\Http\Requests\StoreVideoCommentRequest;
use App\Http\Requests\UpdateVideoCommentRequest;
use App\Models\User;
use App\Models\VideoComment;
use App\Models\VideoList;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VideoCommentsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('video_comment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VideoComment::with(['video', 'user', 'replay_to'])->select(sprintf('%s.*', (new VideoComment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'video_comment_show';
                $editGate      = 'video_comment_edit';
                $deleteGate    = 'video_comment_delete';
                $crudRoutePart = 'video-comments';

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

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('replay_to_name', function ($row) {
                return $row->replay_to ? $row->replay_to->name : '';
            });

            $table->editColumn('comment', function ($row) {
                return $row->comment ? $row->comment : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'video', 'user', 'replay_to']);

            return $table->make(true);
        }

        return view('admin.videoComments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('video_comment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = VideoList::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $replay_tos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.videoComments.create', compact('videos', 'users', 'replay_tos'));
    }

    public function store(StoreVideoCommentRequest $request)
    {
        $videoComment = VideoComment::create($request->all());

        return redirect()->route('admin.video-comments.index');
    }

    public function edit(VideoComment $videoComment)
    {
        abort_if(Gate::denies('video_comment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = VideoList::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $replay_tos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $videoComment->load('video', 'user', 'replay_to');

        return view('admin.videoComments.edit', compact('videos', 'users', 'replay_tos', 'videoComment'));
    }

    public function update(UpdateVideoCommentRequest $request, VideoComment $videoComment)
    {
        $videoComment->update($request->all());

        return redirect()->route('admin.video-comments.index');
    }

    public function show(VideoComment $videoComment)
    {
        abort_if(Gate::denies('video_comment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videoComment->load('video', 'user', 'replay_to');

        return view('admin.videoComments.show', compact('videoComment'));
    }

    public function destroy(VideoComment $videoComment)
    {
        abort_if(Gate::denies('video_comment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videoComment->delete();

        return back();
    }

    public function massDestroy(MassDestroyVideoCommentRequest $request)
    {
        VideoComment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
