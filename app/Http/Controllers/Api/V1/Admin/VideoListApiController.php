<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreVideoListRequest;
use App\Http\Requests\UpdateVideoListRequest;
use App\Http\Resources\Admin\VideoListResource;
use App\Models\VideoList;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoListApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('video_list_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VideoListResource(VideoList::with(['tags', 'categories', 'event', 'channel', 'user'])->get());
    }

    public function store(StoreVideoListRequest $request)
    {
        $videoList = VideoList::create($request->all());
        $videoList->tags()->sync($request->input('tags', []));

        if ($request->input('video', false)) {
            $videoList->addMedia(storage_path('tmp/uploads/' . $request->input('video')))->toMediaCollection('video');
        }

        return (new VideoListResource($videoList))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(VideoList $videoList)
    {
        abort_if(Gate::denies('video_list_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VideoListResource($videoList->load(['tags', 'categories', 'event', 'channel', 'user']));
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

        return (new VideoListResource($videoList))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(VideoList $videoList)
    {
        abort_if(Gate::denies('video_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videoList->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
