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
        $result = Validator( $request->all(), array(
            'productId'        => 'required|integer',
            'storageProduct'    => 'required|max:255:string',
            'qualityProduct'    => 'required|max:255:string',
            'colorProduct'      => 'required|max:255:string',
            'quantityProduct'   => 'required|integer',
            'priceProduct'      => 'required|integer',
            'totalPrice'        => 'required|integer',
            'isInput'           => 'required|integer'
        ));

        if ( ! $result->fails()) {
            $saler              = $request->input('saler');
            $productId          = $request->input('productId');
            $storageProduct     = $request->input('storageProduct');
            $qualityProduct     = $request->input('qualityProduct');
            $colorProduct       = $request->input('colorProduct');
            $quantityProduct    = $request->input('quantityProduct');
            $inputDate          = $request->input('inputDate');
            $priceProduct       = $request->input('priceProduct');
            $totalPrice         = $request->input('totalPrice');
            $depotNote          = $request->input('depotNote');
            $isInput          = $request->input('isInput');

            if( DB::table('depots')
                ->insert([
                    'saler'              => $saler,
                    'product_id'         => $productId,
                    'storage_product'    => $storageProduct,
                    'quality_product'    => $qualityProduct,
                    'color_product'      => $colorProduct,
                    'quantity_product'   => $quantityProduct,
                    'input_date'         => Carbon::createFromFormat('d/m/Y', $inputDate)->toDateString(),
                    'price_product'      => $priceProduct,
                    'total_price'        => $totalPrice,
                    'depot_note'         => $depotNote,
                    'is_input_depot'     => $isInput
                ]))
            {
                $ob_quantityInStock = DB::table('products')
                                    ->select('quantity_in_stock')
                                    ->first();

                DB::table('products')
                    ->where('id', $productId)
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

    /**
     * get all depots
     *
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function getDepots()
    {
        $depots = DB::select("select id, saler, (select product_name from products t2 where t2.id = t1.product_id) as product_name, storage_product, color_product, quality_product, price_product, quantity_product, total_price, depot_note, input_date, is_input_depot from depots t1 where 1 ");

        return Datatables::of($depots)
            ->editColumn('input_date', function ($depot) {
                return $depot->input_date ? with(new Carbon($depot->input_date))->format('d/m/Y') : '';
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
