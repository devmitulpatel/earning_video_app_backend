<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoLikeRequest;
use App\Http\Requests\UpdateVideoLikeRequest;
use App\Http\Resources\Admin\VideoLikeResource;
use App\Models\VideoLike;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoLikesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('video_like_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VideoLikeResource(VideoLike::with(['video', 'like_bies'])->get());
    }

    public function store(StoreVideoLikeRequest $request)
    {
        $videoLike = VideoLike::create($request->all());
        $videoLike->like_bies()->sync($request->input('like_bies', []));

        return (new VideoLikeResource($videoLike))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(VideoLike $videoLike)
    {
        abort_if(Gate::denies('video_like_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VideoLikeResource($videoLike->load(['video', 'like_bies']));
    }

    public function update(UpdateVideoLikeRequest $request, VideoLike $videoLike)
    {
        $videoLike->update($request->all());
        $videoLike->like_bies()->sync($request->input('like_bies', []));

        return (new VideoLikeResource($videoLike))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(VideoLike $videoLike)
    {
        abort_if(Gate::denies('video_like_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videoLike->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
