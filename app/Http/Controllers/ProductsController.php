<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Log;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use DataTables;
use DB;

class ProductsController extends Controller
{
    public function index()
    {
        $data['brands'] = Brand::all();
        return view('products.index')->with($data);
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('products as a')
                    ->select('a.name', 'a.slug', 'a.brand_id', 'a.stock', 'a.price', 'a.created_at', 'a.barcode', 'b.id', 'b.name as brand')
                    ->join('brands as b', 'a.brand_id', '=', 'b.id')
                    ->orderBy('a.created_at', 'DESC');
    // dd($data);

            return DataTables::of($data)
            ->editColumn('action', function($row) {
                $var = '<center>';
                $var .= '<button type="button" class="btn btn-xs btn-warning mr-2" data-bs-toggle="modal" data-bs-target="#editProductModal" title="Edit" onclick="editData(\''.base64_encode($row->slug ).'\')"><i class="fas fa-pencil-alt"></i></button>';
                $var .= '<button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="deleteData(\''.base64_encode($row->slug ).'\')"><i class="fas fa-trash"></i></button>';
                $var .= '</center>'; 
                return $var;
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
            $validated = $request->validate([
                'name' => 'required|min:3',
                'slug' => 'required|unique:products,slug',
                'stock' => 'required|numeric',
                'price' => 'required|numeric',
                'barcode' => 'required|unique:products,barcode',
                'brand_id' => 'required'
            ]);
            
            Product::create($validated);

            $log->insertLog('Created an product');
            return redirect()->back()->with('sweet_alert', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Success created new product!'
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('sweet_alert', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error : '.$e
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $log = new Log();
            $slug = base64_decode($request->slug);
            Product::where('slug', $slug)->delete();

            $log->insertLog('Deleted an product');

            return response()->json(['indctr' => 0, 'message' => 'Success delete product']);
        } catch (Exception $e) {
            return response()->json(['indctr' => 1, 'message' => 'Error : '.$e]);
        }
    }

    public function slug(Request $request)
    {
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
