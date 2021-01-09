<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyVideoListRequest;
use App\Http\Requests\StoreVideoListRequest;
use App\Http\Requests\UpdateVideoListRequest;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Event;
use App\Models\Tag;
use App\Models\User;
use App\Models\VideoList;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VideoListController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('video_list_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VideoList::with(['tags', 'categories', 'event', 'channel', 'user'])->select(sprintf('%s.*', (new VideoList)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'video_list_show';
                $editGate      = 'video_list_edit';
                $deleteGate    = 'video_list_delete';
                $crudRoutePart = 'video-lists';

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
            $table->editColumn('video', function ($row) {
                return $row->video ? '<a href="' . $row->video->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('tags', function ($row) {
                $labels = [];

                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->addColumn('categories_name', function ($row) {
                return $row->categories ? $row->categories->name : '';
            });

            $table->addColumn('event_name', function ($row) {
                return $row->event ? $row->event->name : '';
            });

            $table->addColumn('channel_name', function ($row) {
                return $row->channel ? $row->channel->name : '';
            });

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'video', 'tags', 'categories', 'event', 'channel', 'user']);

            return $table->make(true);
        }

        return view('admin.videoLists.index');
    }

    public function create()
    {
        abort_if(Gate::denies('video_list_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tags = Tag::all()->pluck('name', 'id');

        $categories = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $events = Event::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $channels = Channel::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.videoLists.create', compact('tags', 'categories', 'events', 'channels', 'users'));
    }

    public function store(StoreVideoListRequest $request)
    {
        $videoList = VideoList::create($request->all());
        $videoList->tags()->sync($request->input('tags', []));

        if ($request->input('video', false)) {
            $videoList->addMedia(storage_path('tmp/uploads/' . $request->input('video')))->toMediaCollection('video');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $videoList->id]);
        }

        return redirect()->route('admin.video-lists.index');
    }

    public function edit(VideoList $videoList)
    {
        abort_if(Gate::denies('video_list_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tags = Tag::all()->pluck('name', 'id');

        $categories = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $events = Event::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $channels = Channel::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $videoList->load('tags', 'categories', 'event', 'channel', 'user');

        return view('admin.videoLists.edit', compact('tags', 'categories', 'events', 'channels', 'users', 'videoList'));
    }

    public function update(UpdateVideoListRequest $request, VideoList $videoList)
    {
        $videoList->update($request->all());
        $videoList->tags()->sync($request->input('tags', []));

        if ($request->input('video', false)) {
            if (!$videoList->video || $request->input('video') !== $videoList->video->file_name) {
                if ($videoList->video) {
                    $videoList->video->delete();
                }

                $videoList->addMedia(storage_path('tmp/uploads/' . $request->input('video')))->toMediaCollection('video');
            }
        } elseif ($videoList->video) {
            $videoList->video->delete();
        }

        return redirect()->route('admin.video-lists.index');
    }

    public function show(VideoList $videoList)
    {
        abort_if(Gate::denies('video_list_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videoList->load('tags', 'categories', 'event', 'channel', 'user');

        return view('admin.videoLists.show', compact('videoList'));
    }

    public function destroy(VideoList $videoList)
    {
        abort_if(Gate::denies('video_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videoList->delete();

        return back();
    }

    public function massDestroy(MassDestroyVideoListRequest $request)
    {
        VideoList::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('video_list_create') && Gate::denies('video_list_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new VideoList();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
