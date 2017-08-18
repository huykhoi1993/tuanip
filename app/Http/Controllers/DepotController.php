<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
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
        return view('admin.depots_management');
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
                'priceProduct'      => 'required|integer',
                'totalPrice'        => 'required|integer',
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
                $totalPrice         = $request->input('totalPrice');
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
                        'total_price'        => $totalPrice,
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
                'priceProduct'      => 'required|integer',
                'totalPrice'        => 'required|integer',
            ));

            if ( ! $result->fails()) {
                echo "ok";
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
                $totalPrice         = $request->input('totalPrice');
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
                        'total_price'        => $totalPrice,
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
                    ->select('id', 'saler', 'product_name', 'storage_product', 'color_product', 'quantity_product', 'quality_product', 'is_quocte', 'price_product', 'total_price', 'pay_type', 'depot_note', 'input_date', 'is_input_depot')
                    ->get();
                    
        return Datatables::of($depots)
            ->editColumn('input_date', function ($depot) {
                return $depot->input_date ? with(new Carbon($depot->input_date))->format('d/m/Y') : '';
            })
            ->editColumn('is_quocte', function ($depot) {
                return $depot->is_quocte == 1 ? 'Quốc tế' : 'Lock';
            })
            ->editColumn('is_input_depot', function ($depot) {
                return $depot->is_input_depot == 1 ? 'Nhập' : 'Xuất';
            })
            ->editColumn('price_product', function ($depot) {
                return number_format($depot->price_product, 0, ",", ".");
            })
            ->editColumn('depot_note', function ($depot) {
                return substr($depot->depot_note, 0, 12);
            })
            ->editColumn('total_price', function ($depot) {
                return number_format($depot->total_price, 0, ",", ".");
            })
            ->make();
    }
}
