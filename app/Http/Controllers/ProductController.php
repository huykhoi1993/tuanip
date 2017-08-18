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
                                'quantity_in_stock' => $quantity_in_stock,
                                'created_at'        => Carbon::now()
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
        $products = DB::select("select id, product_name, color_product, storage_product, quality_product, is_quocte, (select category_name from categories t2 where t2.id = t1.vendor_id) as vendor_name, quantity_in_stock, product_info, created_at from products t1 where 1");

        return Datatables::of($products)
            ->editColumn('is_quocte', function ($product) {
                return $product->is_quocte == 1 ? 'Quốc tế' : 'Lock';
            })
            ->editColumn('created_at', function ($product) {
                return $product->created_at ? with(new Carbon($product->created_at))->format('d/m/Y') : '';
            })
            ->make();
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
