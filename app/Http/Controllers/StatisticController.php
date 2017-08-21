<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StatisticController extends Controller
{
    
    public function getAllProducts()
    {
    	// Lấy tổng các sản phẩm có trong kho
    	$total_all_products = DB::table('products')
    		->select(
    			DB::raw('sum(quantity_in_stock) as total_all_products')
			)
    		->get();
    	
    	// Lấy tổng của từng nhóm sản phẩm
    	$total_every_products = DB::table('products')
    		->select(
    			'product_name',
    			DB::raw('sum(quantity_in_stock) as total_products')
			)
			->groupBy('product_name')
			->get();

		// Lấy chi tiết từng sản phẩm
		$detail_products = DB::table('products')
    		->select(
    			'product_name',
    			'color_product',
    			'storage_product',
    			'quality_product',
    			'is_quocte',
    			'quantity_in_stock'
			)
			->get();

		return response()->json([
			'total_all_products' => $total_all_products,
			'total_every_products' => $total_every_products,
			'detail_products' => $detail_products
		]);
    }

    public function getTotalMoneyImport()
    {
    	// Lấy tổng tiền hàng đã nhập
    	$money_import = DB::table('depots')
    		->select(
    			DB::raw('sum(total_price) as total_money_import')
			)
			->where([
				['is_input_depot', '=', 1]
			])
			->get();

		// Lấy tiền hàng đã nhập với từng nhóm
		$money_import_every_type = DB::table('depots')
			->select(
				'product_name',
				DB::raw('sum(total_price) as total_money_import')
			)
			->where([
				['is_input_depot', '=', 1]
			])
			->groupBy('product_name')
			->get();

		//Lấy tiền hàng đã nhập chi tiết từng loại
		$money_import_every_product = DB::table('depots')
			->select(
				'product_name',
				'storage_product',
				'quality_product',
				'color_product',
				'is_quocte',
				'total_price'
			)
			->where([
				['is_input_depot', '=', 1]
			])
			->get();

		return response()->json([
			'money_import' 					=> $money_import,
			'money_import_every_type' 		=> $money_import_every_type,
			'money_import_every_product' 	=> $money_import_every_product
		]);
    }

    public function getTotalMoneyExport(Request $request)
    {
	  	// Lấy tổng tiền hàng đã xuất
    	$money_export = DB::table('depots')
    		->select(
    			DB::raw('sum(total_price) as total_money_export')
			)
			->where([
				['is_input_depot', '=', 0]
			])
			->get();

		// Lấy tiền hàng đã xuất với từng nhóm
		$money_export_every_type = DB::table('depots')
			->select(
				'product_name',
				DB::raw('sum(total_price) as total_money_export')
			)
			->where([
				['is_input_depot', '=', 0]
			])
			->groupBy('product_name')
			->get();

		//Lấy tiền hàng đã nhập chi tiết từng loại
		$money_export_every_product = DB::table('depots')
			->select(
				'product_name',
				'storage_product',
				'quality_product',
				'color_product',
				'is_quocte',
				'total_price'
			)
			->where([
				['is_input_depot', '=', 0]
			])
			->get();

		return response()->json([
			'money_export' 					=> $money_export,
			'money_export_every_type' 		=> $money_export_every_type,
			'money_export_every_product' 	=> $money_export_every_product
		]);
    }
}
