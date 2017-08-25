<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;
use Carbon\Carbon;
use Datatables;

class DepotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_import = DB::table('depots')
                        ->select(
                            DB::raw('sum(total_price) as total')
                        )
                        ->where([
                            ['is_input_depot', '=', 1]
                        ])
                        ->get();

        $total_export = DB::table('depots')
                        ->select(
                            DB::raw('sum(total_price) as total')
                        )
                        ->where([
                            ['is_input_depot', '=', 0]
                        ])
                        ->get();

        return view('admin.depots_management',[
                'total_import'  => number_format($total_import[0]->total, 0, ",", "."),
                'total_export'  => number_format($total_export[0]->total, 0, ",", ".")
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( $request->input('isInput') == 1) {
            $result = Validator( $request->all(), array(
                'productName'       => 'required|max:255:string',
                'storageProduct'    => 'required|max:255:string',
                'qualityProduct'    => 'required|max:255:string',
                'colorProduct'      => 'required|max:255:string',
                'is_quocte'         => 'required|integer',
                'thanhToan'         => 'required|max:255:string',
                'quantityProduct'   => 'required|integer',
                'priceProduct'      => 'required|integer'
            ));

            if ( ! $result->fails()) {
                $saler              = $request->input('saler');
                $productName        = $request->input('productName');
                $storageProduct     = $request->input('storageProduct');
                $qualityProduct     = $request->input('qualityProduct');
                $colorProduct       = $request->input('colorProduct');
                $quantityProduct    = $request->input('quantityProduct');
                $is_quocte          = $request->input('is_quocte');
                $pay_type           = $request->input('thanhToan');
                $inputDate          = $request->input('inputDate');
                $priceProduct       = $request->input('priceProduct');
                $depotNote          = $request->input('depotNote');
                $isInput            = $request->input('isInput');

                if( DB::table('depots')
                    ->insert([
                        'saler'              => $saler,
                        'product_name'       => $productName,
                        'storage_product'    => $storageProduct,
                        'quality_product'    => $qualityProduct,
                        'color_product'      => $colorProduct,
                        'quantity_product'   => $quantityProduct,
                        'is_quocte'          => $is_quocte,
                        'pay_type'           => $pay_type,
                        'input_date'         => Carbon::createFromFormat('d/m/Y', $inputDate)->toDateString(),
                        'price_product'      => $priceProduct,
                        'total_price'        => $priceProduct * $quantityProduct,
                        'depot_note'         => $depotNote,
                        'is_input_depot'     => $isInput
                    ]))
                {

                    $ob_quantityInStock = DB::table('products')
                                        ->select('quantity_in_stock')
                                        ->where([
                                            ['product_name', '=', $productName],
                                            ['storage_product', '=', $storageProduct],
                                            ['quality_product', '=', $qualityProduct],
                                            ['color_product', '=', $colorProduct],
                                            ['is_quocte', '=', $is_quocte],
                                        ])
                                        ->first();
                                        
                    DB::table('products')
                        ->where([
                            ['product_name', '=', $productName],
                            ['storage_product', '=', $storageProduct],
                            ['quality_product', '=', $qualityProduct],
                            ['color_product', '=', $colorProduct],
                            ['is_quocte', '=', $is_quocte],
                        ])
                        ->update([
                            'quantity_in_stock' => ($ob_quantityInStock->quantity_in_stock + $quantityProduct),
                            'updated_at'        => Carbon::now()
                        ]);

                    return response()->json([
                        'message' => 'OK'
                    ]); 
                }
            }
            else {
                return response()->json([
                    'message' => 'NG'
                ]);
            }
        }
        else {
            $result = Validator( $request->all(), array(
                'productName'       => 'required|max:255:string',
                'storageProduct'    => 'required|max:255:string',
                'qualityProduct'    => 'required|max:255:string',
                'colorProduct'      => 'required|max:255:string',
                'isQuocte'          => 'required|integer',
                'thanhToan'         => 'required|max:255:string',
                'quantityProduct'   => 'required|integer',
                'priceProduct'      => 'required|integer'
            ));

            if ( ! $result->fails()) {
                $buyer              = $request->input('buyer');
                $productName        = $request->input('productName');
                $storageProduct     = $request->input('storageProduct');
                $qualityProduct     = $request->input('qualityProduct');
                $colorProduct       = $request->input('colorProduct');
                $quantityProduct    = $request->input('quantityProduct');
                $isQuocte           = $request->input('isQuocte');
                $pay_type           = $request->input('thanhToan');
                $inputDate          = $request->input('inputDate');
                $priceProduct       = $request->input('priceProduct');
                $depotNote          = $request->input('depotNote');
                $isInput            = $request->input('isInput');

                if( DB::table('depots')
                    ->insert([
                        'saler'              => $buyer,
                        'product_name'       => $productName,
                        'storage_product'    => $storageProduct,
                        'quality_product'    => $qualityProduct,
                        'color_product'      => $colorProduct,
                        'quantity_product'   => $quantityProduct,
                        'is_quocte'          => $isQuocte,
                        'pay_type'           => $pay_type,
                        'input_date'         => Carbon::createFromFormat('d/m/Y', $inputDate)->toDateString(),
                        'price_product'      => $priceProduct,
                        'total_price'        => $priceProduct * $quantityProduct,
                        'depot_note'         => $depotNote,
                        'is_input_depot'     => $isInput
                    ]))
                {
                    $ob_quantityInStock = DB::table('products')
                                        ->select('quantity_in_stock')
                                        ->where([
                                            ['product_name', '=', $productName],
                                            ['storage_product', '=', $storageProduct],
                                            ['quality_product', '=', $qualityProduct],
                                            ['color_product', '=', $colorProduct],
                                            ['is_quocte', '=', $isQuocte],
                                        ])
                                        ->first();

                    DB::table('products')
                        ->where([
                            ['product_name', '=', $productName],
                            ['storage_product', '=', $storageProduct],
                            ['quality_product', '=', $qualityProduct],
                            ['color_product', '=', $colorProduct],
                            ['is_quocte', '=', $isQuocte],
                        ])
                        ->update([
                            'quantity_in_stock' => ($ob_quantityInStock->quantity_in_stock - $quantityProduct),
                            'updated_at'        => Carbon::now()
                        ]);

                    return response()->json([
                        'message' => 'OK'
                    ]); 
                }
            }
            else {
                return response()->json([
                    'message' => 'NG'
                ]);
            }

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * get all depots
     *
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function getDepots()
    {
        $depots = DB::table('depots')
                    ->select(
                        'id', 
                        'saler', 
                        'product_name', 
                        'storage_product', 
                        'color_product', 
                        'quantity_product', 
                        'quality_product', 
                        DB::raw('CASE is_quocte WHEN 0 THEN "' 
                            . Config::get('array.VERSIONS.0') 
                            . '" WHEN 1 THEN "' 
                            . Config::get('array.VERSIONS.1') 
                            . '" END AS version'),
                        'price_product', 
                        'total_price', 
                        'pay_type', 
                        'depot_note', 
                        DB::raw("DATE_FORMAT(input_date, '%d/%m/%Y') AS input_date"),
                        DB::raw('CASE is_input_depot WHEN 0 THEN "Xuất" WHEN 1 THEN "Nhập" END AS is_input_depot')
                    )
                    ->get();
                    
        return Datatables::of($depots)
            ->editColumn('price_product', function ($depot) {
                return number_format($depot->price_product, 0, ",", ".");
            })
            ->editColumn('depot_note', function ($depot) {
                return substr($depot->depot_note, 0, 12);
            })
            ->editColumn('total_price', function ($depot) {
                return number_format($depot->total_price, 0, ",", ".");
            })
            ->make(true);
    }
}
