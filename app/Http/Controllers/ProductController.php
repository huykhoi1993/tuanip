<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;
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
        $total_products = DB::table('products')
                            ->select(
                                DB::raw('sum(quantity_in_stock) as quantity')
                            )
                            ->get();

        $most_product = DB::table('products')
                            ->select(
                                'product_name as name',
                                DB::raw('sum(quantity_in_stock) as quantity')
                            )
                            ->groupBy('product_name')
                            ->orderBy('quantity', 'DESC')
                            ->first();

        return view('admin.products',[
                'total_products'    => $total_products[0]->quantity,
                'most_product'      => $most_product
            ]);
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

        $success    = 0;
        $fails      = 0;

        if ( ! $result->fails()) {
            $product_name       = $request->input('product_name');
            $colors             = $request->input('colors');
            $storages           = $request->input('storages');
            $qualities          = $request->input('qualities');
            $is_quocte          = $request->input('is_quocte') == 'true' ? 1 : 0 ;
            $product_info       = $request->input('product_info');
            $vendor_id          = $request->input('vendor_id');
            $quantity_in_stock  = $request->input('quantity_in_stock');

            foreach ( $colors as $color ) {
                foreach ( $storages as $storage ) {
                    foreach ( $qualities as $quality ) {

                        $found = DB::table('products')->where([
                            ['product_name', '=', $product_name ],
                            ['color_product', '=', $color ],
                            ['storage_product', '=', $storage ],
                            ['quality_product', '=', $quality ],
                            ['is_quocte', '=', $is_quocte ],
                            ['vendor_id', '=', $vendor_id ],
                        ])->first();

                        // Nếu tìm thấy sản phẩm trong database thì không insert
                        if ( $found) {
                            $fails += 1;    
                        }
                        else {
                            $ret = DB::table('products')->insert([
                                'product_name'      => $product_name,
                                'color_product'     => $color,
                                'storage_product'   => $storage,
                                'quality_product'   => $quality,
                                'is_quocte'         => $is_quocte,
                                'product_info'      => $product_info,
                                'vendor_id'         => $vendor_id,
                                // 'quantity_in_stock' => $quantity_in_stock,
                                'quantity_in_stock' => rand(0,100), //Hardcode
                                'created_at'        => Carbon::now(),
                                'updated_at'        => Carbon::now()
                            ]);
                            $success += 1;
                        }
                    }
                }
            }

            return response()->json([
                'message'       => 'OK',
                'count_success' => $success,
                'count_fail'    => $fails
            ]); 
        }
        else {
            return response()->json([
                'message' => 'NG'
            ]);
        }
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
                    'quantity_in_stock' => $request->input('quantity_in_stock')
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
        $products = DB::table('products')
                    ->join('categories', 'categories.id', '=', 'products.vendor_id')
                    ->select(
                        'products.id',
                        'products.product_name',
                        'products.color_product',
                        'products.storage_product',
                        'products.quality_product',
                        DB::raw('CASE products.is_quocte WHEN 0 THEN "' 
                            . Config::get('array.VERSIONS.0') 
                            . '" WHEN 1 THEN "' 
                            . Config::get('array.VERSIONS.1') 
                            . '" END AS version'),
                        'categories.category_name AS vendor_name',
                        'products.quantity_in_stock',
                        'products.product_info',
                        DB::raw("DATE_FORMAT(products.updated_at, '%d/%m/%Y') AS updated_at")
                    )
                    ->get();

        return Datatables::of($products)
            ->make(true);
    }

    public function getProductsName()
    {
        $results = DB::table('products')
                    ->select('product_name')
                    ->groupBy('product_name')
                    ->get();

        return response()->json($results);
    }

    public function getStoragesProduct(Request $request)
    {
        $productName = $request->input('product_name');
        $results = DB::table('products')
                    ->select('storage_product')
                    ->where('product_name', '=', $productName)
                    ->groupBy('storage_product')
                    ->get();

        return response()->json($results);
    }

    public function getQualitiesProduct(Request $request)
    {
        $productName    = $request->input('product_name');
        $storageProduct = $request->input('storage_product');
        $results = DB::table('products')
                    ->select('quality_product')
                    ->where([
                        ['product_name', '=', $productName],
                        ['storage_product', '=', $storageProduct],
                    ])
                    ->groupBy('quality_product')
                    ->get();
        return response()->json($results);
    }

    public function getColorsProduct(Request $request)
    {
        $productName    = $request->input('product_name');
        $storageProduct = $request->input('storage_product');
        $qualityProduct = $request->input('quality_product');
        $results = DB::table('products')
                    ->select('color_product')
                    ->where([
                        ['product_name', '=', $productName],
                        ['storage_product', '=', $storageProduct],
                        ['quality_product', '=', $qualityProduct],
                    ])
                    ->groupBy('color_product')
                    ->get();

        return response()->json($results);
    }

    public function getVersionsProduct(Request $request)
    {
        $productName    = $request->input('product_name');
        $storageProduct = $request->input('storage_product');
        $qualityProduct = $request->input('quality_product');
        $colorProduct   = $request->input('color_product');

        $results = DB::table('products')
                    ->select('is_quocte')
                    ->where([
                        ['product_name', '=', $productName],
                        ['storage_product', '=', $storageProduct],
                        ['quality_product', '=', $qualityProduct],
                        ['color_product', '=', $colorProduct],
                    ])
                    ->get();

        return response()->json($results);
    }


}
