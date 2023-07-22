<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;
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
                $var .= '<button type="button" class="btn btn-xs btn-warning mr-2" data-bs-toggle="modal" data-bs-target="#editUserModal" title="Edit" onclick="editData(\''.base64_encode($row->email ).'\')"><i class="fas fa-pencil-alt"></i></button>';
                $var .= '<button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="deleteData(\''.base64_encode($row->email ).'\')"><i class="fas fa-trash"></i></button>';
                $var .= '</center>'; 
                return $var;
            })
            ->editColumn('role', function($row) {
                $roleName = User::find($row->id)->roles->pluck('name')->first();
                return $roleName;
            })
            ->make(true);
        }else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        try {
            $log = new Log();
            // dd($request->all());
            $validate = $request->validate([
                'name' => 'required|min:5',
                'email' => 'required|email:dns|unique:users,email',
                'phoneNo' => 'required|numeric',
                'address' => 'required|min:10',
                'role' => 'required',
                // 'permission' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $user = new User();
            $user->name = $validate['name'];
            $user->email = $validate['email'];
            $user->phoneNo = $validate['phoneNo'];
            $user->address = $validate['address'];
            $user->password = bcrypt('123456');
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . $validate['name'] . '.'.$image->getClientOriginalExtension();
                // dd($imageName);
                $image->storeAs('public/users', $imageName);
                $user->image = 'users/' . $imageName;
            }
    
            $user->save();
            $user->addRole($request->role);

            $log->insertLog('Created an account');
            // $log->save();
    
            return redirect()->back()->with('sweet_alert', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Success created new user!'
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('sweet_alert', [
                'icon' => 'error',
                'title' => 'Error',
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
        // dd($request->all());
        try {
            // dd($request->email);
            $log = new Log();

            $validate = $request->validate([
                'name' => 'required|min:5',
                'phoneNo' => 'required|numeric',
                'address' => 'required|min:10',
                // 'role' => 'required',
                // 'permission' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $user = User::find($request->user);
            // dd($user->image);
            $user->name = $validate['name'];
            $user->phoneNo = $validate['phoneNo'];
            $user->address = $validate['address'];
    
            if ($request->hasFile('image')) {
                if ($checkImage->image) {
                    Storage::delete($checkImage->image);
                }
                $image = $request->file('image');
                $imageName = time() . '-' . $validate['name'] . '.'.$image->getClientOriginalExtension();
                // dd($imageName);
                $image->storeAs('public/users', $imageName);
                $user->image = 'users/' . $imageName;
            }
    
            $user->save();
            // $user->updateRole($request->role);

            $log->insertLog('Updated an account');
            // $log->save();
    
            return redirect()->back()->with('sweet_alert', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Success created new user!'
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('sweet_alert', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error : '.$e
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $log = new Log();
            $email = base64_decode($request->email);
            User::where('email', $email)->delete();

            $log->insertLog('Deleted an account');

            return response()->json(['indctr' => 0, 'message' => 'Success delete user']);
        } catch (Exception $e) {
            return response()->json(['indctr' => 1, 'message' => 'Error : '.$e]);
        }
    }
}
