<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Datatables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // $name = self::handleStr($request->input('name'));
        // $name = self::handleStr($request->input('name'));
        $result = Validator( $request->all(), array(
            'category_name' => 'required|max:255:string',
        ));

        if ( ! $result->fails()) {
            DB::table('categories')->insert([
                'category_name' => $request->input('category_name'),
                'category_note' => $request->input('category_note'),
                'parent_id'     => is_numeric($request->input('parent_id')) ? $request->input('parent_id') : NULL,
                'created_at'    => Carbon::now()
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCategory(Request $request, $id)
    {
        if ( $request->input('method') == 'PUT') {
            $results = DB::table('categories')
                ->where('id', '=', $id)
                ->update([
                    'parent_id'     => is_numeric($request->input('parent_id')) ? $request->input('parent_id') : NULL,
                    'category_name' => $request->input('category_name'),
                    'category_note' => $request->input('category_note'),
                    'updated_at'    => Carbon::now()
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
    public function removeCategory(Request $request, $id)
    {
        if ( $request->input('method') == 'DELETE') {
            $results = DB::table('categories')
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
     * remove space at first and end of string,
     * replace some space by a space character
     * @param  string  $str
     * @return string
     */
    public function handleStr($str_input)
    {
        $str = trim($str_input);
        $str = preg_replace('/\s+/',' ',$str);
        return $str;
    }

    /**
     * get all category name in categories table
     * @param  none
     * @return array category name
     */
    public function getCategoryName()
    {
        $results = DB::table('categories')->get();
        return response()->json($results);
    }

    /**
     * get all category name in categories table
     * @param  none
     * @return all data categories
     */
    public function getCategories()
    {
        $categories = DB::select("select id, category_name, (select category_name from categories t2 where t2.id = t1.parent_id) as parent_name, category_note, created_at from categories t1 where 1");

        return Datatables::of($categories)
            ->editColumn('created_at', function ($category) {
                return $category->created_at ? with(new Carbon($category->created_at))->format('H:s:i d/m/Y') : '';
            })
            ->make();
    }
}
