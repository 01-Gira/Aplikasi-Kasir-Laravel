<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Laratrust\LaratrustFacade as Laratrust;
use DataTables;
use DB;

class UsersController extends Controller
{
    public function index()
    {
        $data['roles'] = Role::all(); 
        return view('users.index')->with($data);
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users as a')
                    ->orderBy('created_at', 'DESC');
            // dd($data);

            return DataTables::of($data)
            ->editColumn('action', function($row) {
                $var = '<center>';
                $var .= '<button type="button" class="btn btn-xs btn-warning mr-2" data-bs-toggle="modal" data-bs-target="#editUserModal" data-whatever="'.base64_encode($row->email).'" title="Edit"><i class="fas fa-pencil-alt"></i></button>';
                $var .= '<button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"> </i></button>';
                $var .= '</center>'; 
                return $var;
            })
            ->editColumn('role', function($row) {
                $roleName = User::find($row->id)->roles->pluck('name')->first();
                return $roleName;
            })
            ->rawColumns(['action'])
            ->make(true);
        }else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = $request->validate([
                'name' => 'required|min:5',
                'email' => 'required|email',
                'phoneNo' => 'required|numeric',
                'address' => 'required|min:10',
                'role' => 'required',
                'permission' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            // dd($request->role);
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phoneNo = $request->phoneNo;
            $user->address = $request->address;
            $user->password = bcrypt('123456');
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . $request->name . '.'.$image->getClientOriginalExtension();
                // dd($imageName);
                $image->storeAs('public/users', $imageName);
                $user->image = 'users/' . $imageName;
            }
    
            $user->save();
            // $user->addRole($request->role);
    
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('sweet_alert', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => 'Error : '.$e
            ]);
        }
       
    }

    public function getData(Request $request)
    {
        $email = base64_decode($request->email);
        $data = User::where('email', $email)->first();
      
        return response()->json(['indctr' => 0, 'message' => 'Data found', 'data' => $data]);
    }

    public function update(Request $request)
    {
        dd($request->all());
    }
}
