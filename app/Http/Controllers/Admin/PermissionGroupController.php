<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionGroupRequest;
use App\Http\Requests\StorePermissionGroupRequest;
use App\Http\Requests\UpdatePermissionGroupRequest;
use App\Models\PermissionGroup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PermissionGroupController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('permission_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PermissionGroup::query()->select(sprintf('%s.*', (new PermissionGroup)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'permission_group_show';
                $editGate      = 'permission_group_edit';
                $deleteGate    = 'permission_group_delete';
                $crudRoutePart = 'permission-groups';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.permissionGroups.index');
    }

    public function create()
    {
        abort_if(Gate::denies('permission_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissionGroups.create');
    }

    public function store(StorePermissionGroupRequest $request)
    {
        $permissionGroup = PermissionGroup::create($request->all());

        return redirect()->route('admin.permission-groups.index');
    }

    public function edit(PermissionGroup $permissionGroup)
    {
        abort_if(Gate::denies('permission_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissionGroups.edit', compact('permissionGroup'));
    }

    public function update(UpdatePermissionGroupRequest $request, PermissionGroup $permissionGroup)
    {
        $permissionGroup->update($request->all());

        return redirect()->route('admin.permission-groups.index');
    }

    public function destroy(PermissionGroup $permissionGroup)
    {
        abort_if(Gate::denies('permission_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissionGroup->delete();

        return back();
    }

    public function massDestroy(MassDestroyPermissionGroupRequest $request)
    {
        PermissionGroup::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
