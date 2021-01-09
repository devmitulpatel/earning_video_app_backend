<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoCommentRequest;
use App\Http\Requests\UpdateVideoCommentRequest;
use App\Http\Resources\Admin\VideoCommentResource;
use App\Models\VideoComment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoCommentsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('video_comment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VideoCommentResource(VideoComment::with(['video', 'user', 'replay_to'])->get());
    }

    public function store(StoreVideoCommentRequest $request)
    {
        $videoComment = VideoComment::create($request->all());

        return (new VideoCommentResource($videoComment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(VideoComment $videoComment)
    {
        abort_if(Gate::denies('video_comment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VideoCommentResource($videoComment->load(['video', 'user', 'replay_to']));
    }

    public function update(UpdateVideoCommentRequest $request, VideoComment $videoComment)
    {
        $videoComment->update($request->all());

        return (new VideoCommentResource($videoComment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(VideoComment $videoComment)
    {
        abort_if(Gate::denies('video_comment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videoComment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
