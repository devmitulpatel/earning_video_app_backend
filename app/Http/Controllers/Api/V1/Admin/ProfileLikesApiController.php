<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileLikeRequest;
use App\Http\Requests\UpdateProfileLikeRequest;
use App\Http\Resources\Admin\ProfileLikeResource;
use App\Models\ProfileLike;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileLikesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('profile_like_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProfileLikeResource(ProfileLike::with(['profile_by', 'like_bies'])->get());
    }

    public function store(StoreProfileLikeRequest $request)
    {
        $profileLike = ProfileLike::create($request->all());
        $profileLike->like_bies()->sync($request->input('like_bies', []));

        return (new ProfileLikeResource($profileLike))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ProfileLike $profileLike)
    {
        abort_if(Gate::denies('profile_like_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProfileLikeResource($profileLike->load(['profile_by', 'like_bies']));
    }

    public function update(UpdateProfileLikeRequest $request, ProfileLike $profileLike)
    {
        $profileLike->update($request->all());
        $profileLike->like_bies()->sync($request->input('like_bies', []));

        return (new ProfileLikeResource($profileLike))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ProfileLike $profileLike)
    {
        abort_if(Gate::denies('profile_like_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profileLike->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
