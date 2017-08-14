<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Datatables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo "create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = Validator( $request->all(), array(
            'product_name' => 'required|max:255:string',
        ));

        if ( ! $result->fails()) {
            DB::table('products')->insert([
                'product_name'      => $request->input('product_name'),
                'color_product'     => $request->input('colorProduct'),
                'storage_product'   => $request->input('storageProduct'),
                'quality_product'   => $request->input('qualityProduct'),
                'product_info'      => $request->input('product_info'),
                'vendor_id'         => $request->input('vendor_id'),
                'quantity_in_stock' => $request->input('quantity_in_stock'),
                'created_at'        => Carbon::now()
            ]);

            return response()->json([
                'message' => 'OK'
            ]); 
        }
        else {
            return response()->json([
                'message' => 'NG'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo "show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo "edit";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProduct(Request $request, $id)
    {
        if ( $request->input('method') == 'PUT') {
            $results = DB::table('products')
                ->where('id', '=', $id)
                ->update([
                    'vendor_id'         => is_numeric($request->input('vendor_id')) ? $request->input('vendor_id') : NULL,
                    'product_name'      => $request->input('product_name'),
                    'product_info'      => $request->input('product_info'),
                    'quantity_in_stock' => $request->input('quantity_in_stock'),
                    'updated_at'        => Carbon::now()
                ]);
            if ($results) {
                return response()->json([
                    'message' => 'OK'
                ]);
            } 
            else {
                return response()->json([
                    'message' => 'NG'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct(Request $request, $id)
    {
        if ( $request->input('method') == 'DELETE') {
            $results = DB::table('products')
                ->where('id', '=', $id)
                ->delete();

            if ($results) {
                return response()->json([
                    'message' => 'OK'
                ]);
            } 
            else {
                return response()->json([
                    'message' => 'NG'
                ]);
            }
        }
    }    


    /**
     * get all products
     *
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function getProducts()
    {
        $products = DB::select("select id, product_name, color_product, storage_product, quality_product, (select category_name from categories t2 where t2.id = t1.vendor_id) as vendor_name, quantity_in_stock, product_info, created_at from products t1 where 1");

        return Datatables::of($products)
            ->editColumn('created_at', function ($product) {
                return $product->created_at ? with(new Carbon($product->created_at))->format('H:s:i d/m/Y') : '';
            })
            ->make();
    }

    public function getProductsName()
    {
        $results = DB::table('products')->get();
        return response()->json($results);
    }
}
