<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

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
        $result = Validator( $request->all(), array(
            'product_id'        => 'required|integer',
            'storageProduct'    => 'required|max:255:string',
            'qualityProduct'    => 'required|max:255:string',
            'colorProduct'      => 'required|max:255:string',
            'quantityProduct'   => 'required|integer',
            'priceProduct'      => 'required|integer',
            'totalPrice'        => 'required|integer'
        ));

        if ( ! $result->fails()) {
            $saler              = $request->input('saler');
            $product_id         = $request->input('product_id');
            $storageProduct     = $request->input('storageProduct');
            $qualityProduct     = $request->input('qualityProduct');
            $colorProduct       = $request->input('colorProduct');
            $quantityProduct    = $request->input('quantityProduct');
            $inputDate          = $request->input('inputDate');
            $priceProduct       = $request->input('priceProduct');
            $totalPrice         = $request->input('totalPrice');
            $depotNote          = $request->input('depotNote');

            if( DB::table('depots')
                ->insert([
                    'saler'              => $saler,
                    'product_id'         => $product_id,
                    'storage_product'    => $storageProduct,
                    'quality_product'    => $qualityProduct,
                    'color_product'      => $colorProduct,
                    'quantity_product'   => $quantityProduct,
                    'input_date'         => Carbon::createFromFormat('d/m/Y', $inputDate)->toDateString(),
                    'price_product'      => $priceProduct,
                    'total_price'        => $totalPrice,
                    'depot_note'         => $depotNote
                ]))
            {
                $ob_quantityInStock = DB::table('products')
                                    ->select('quantity_in_stock')
                                    ->first();

                DB::table('products')
                    ->where('id', $product_id)
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
}
