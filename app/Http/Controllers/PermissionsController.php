<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use DB;
use DataTables;

class PermissionsController extends Controller
{
    public function index()
    {
        return view('permissions.index');
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('roles')
                    ->orderBy('created_at', 'DESC');

            return DataTables::of($data)
            ->editColumn('action', function($row) {
                $var = '<center>';
                $var .= '<a href="#" type="button" class="btn btn-xs btn-warning" style="margin-right: 3px;" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fas fa-pencil-alt"></i></a>';
                $var .= '<button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"> </i></button>';
                $var .= '</center>'; 
                return $var;
            })
            ->rawColumns(['action'])
            ->make(true);
        }else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $except_token = $request->except(['_token']);
        // dd($except_token);
        for ($i=0; $i < count($except_token['name']); $i++) { 
            $store = [
                'name' => $except_token['name'][$i],
                'display_name' => $except_token['display_name'][$i],
                'description' => $except_token['description'][$i]
            ];

            $permission = new Permission($store);
            $permission->save();
        }
        return redirect()->back();
    }
}
