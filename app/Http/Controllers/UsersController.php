<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use DB;

class UsersController extends Controller
{
    public function index()
    {
        $data['users'] = User::all(); 
        return view('users.index')->with($data);
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users')
                    ->orderBy('created_at', 'DESC');
            // dd($data);

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
        dd($request->all());
    }
}
