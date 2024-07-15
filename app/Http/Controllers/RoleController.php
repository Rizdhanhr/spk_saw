<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use DataTables;
use App\Models\Permission;
use App\Models\Module;
use DB;
use Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */

     public static function middleware(): array
     {
         return [
             new Middleware('can:view-role', only: ['index','getData']),
             new Middleware('can:create-role', only: ['create','store']),
             new Middleware('can:update-role', only: ['edit','update']),
             new Middleware('can:delete-role', only: ['destroy']),
         ];
     }

    // public function __construct()
    // {
    //      $this->middleware('can:view-role', ['only' => ['index','getData']]);
    //      $this->middleware('can:create-role', ['only' => ['create','store']]);
    //      $this->middleware('can:update-role', ['only' => ['edit','update']]);
    //      $this->middleware('can:delete-role', ['only' => ['destroy']]);
    // }

    public function index()
    {
        return view('role.index');
    }

    public function getData(Request $request){
        $role = Role::query();
        return Datatables::of($role)
        ->addColumn('action', function ($row){
            $action = '';
                if($row->id != 1 && Gate::allows('update-role') || Gate::allows('delete-role')){
                    $action .=
                    '<div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Option
                        </button>
                        <ul class="dropdown-menu">';
                          if(Gate::allows('update-role')){
                            $action .=  '<li><a class="dropdown-item" href="'.route('role.edit',$row->id).'">Edit</a></li>';
                          }
                          if(Gate::allows('delete-role')){
                            $action .=   '<li><button type="button" onclick="deleteConfirm('.$row->id.')" class="dropdown-item" >Delete</button></li>';
                          }
                    $action .=
                        '</ul>
                    </div>';
                }
            return $action;
        })
        ->editColumn('updated_at', function ($row){
            return date('Y-m-d',strtotime($row->updated_at));
        })

        ->rawColumns(['action','updated_at'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $module = Module::with('permission')->orderBy('name','ASC')->get();
        return view('role.create',compact('module'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ]);

        try{
            DB::beginTransaction();

                $role = Role::create([
                    'name' => $request->name,
                    'description' => $request->description
                ])->id;

                $access = Role::findOrFail($role);
                $access->permission()->sync($request->permission);

            DB::commit();

            return redirect()->route('role.index')->with('success', 'Data Saved');

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error', 'Error, please contact administrator.')->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if($id == 1){
            abort(403);
        }

        $role = Role::findOrFail($id);
        $module = Module::with('permission')->orderBy('name','ASC')->get();
        return view('role.edit',compact('role','module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if($id == 1){
            abort(403);
        }

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ]);

        try{
            DB::beginTransaction();

                $role = Role::findOrFail($id);
                $role->name = $request->name;
                $role->description = $request->description;
                $role->save();
                $role->permission()->sync($request->permission);

            DB::commit();

            return redirect()->route('role.index')->with('success', 'Data Saved');

        }catch(\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            return redirect()->back()->with('error', 'Error, please contact administrator.')->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id == 1){
            return response()->json(['error' => 'Not Allowed'], 403);
        }

        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['success' => 'Data Deleted'],200);
    }
}
