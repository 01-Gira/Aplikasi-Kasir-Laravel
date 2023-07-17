<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use DB;
use DataTables;


class RolesController extends Controller
{
    public function index()
    {
        return view('roles.index');
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
        // dd($request->all());
        // try {
            $role = $request->validate([
                'name' => 'required|min:3',
                'display_name' => 'required|min:3',
                'description' => 'required'
            ]);

            $role = new Role($role);
            $role->save();
            return redirect()->back();

        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    }
}
