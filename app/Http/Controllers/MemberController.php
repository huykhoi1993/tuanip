<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class MemberController extends Controller
{
    public function index()
	{
        $total_debit = DB::table('members')
                        ->select(
                            DB::raw('sum(debt) AS total')
                        )
                        ->where([
                            ['debt', '<', 0]
                        ])
                        ->get();

        $total_credit = DB::table('members')
                        ->select(
                            DB::raw('sum(debt) AS total')
                        )
                        ->where([
                            ['debt', '>', 0]
                        ])
                        ->get();

		return view('admin.members',[
                'total_credit'  => number_format($total_credit[0]->total, 0, ",", "."),
                'total_debit'   => number_format(-$total_debit[0]->total, 0, ",", ".")
            ]);
	}

	public function store(Request $request)
	{	
		$valid = Validator( $request->all(), array(
            'guestName' 	=> 'required|string',
            'guestPhone' 	=> 'required|numeric',
            'guestAddress' 	=> 'required|string',
        ));

        if (! $valid->fails() ) {
        	$guestName 		= $request->input('guestName');
        	$guestPhone 	= $request->input('guestPhone');
        	$gender 		= $request->input('gender');
        	$guestAddress 	= $request->input('guestAddress');
        	$guestNote 		= $request->input('guestNote');

        	$result = DB::table('members')
        		->insert([
        			'member_name' 		=> $guestName,
					'member_phone' 		=> $guestPhone,
					'is_female' 		=> $gender,
					'member_address' 	=> $guestAddress,
					'member_note' 		=> $guestNote,
    			]);

			if ( $result ) {
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

		return response()->json([
			'message' => 'NG'
		]);
	}

	public function deleteMember(Request $request)
	{
		$valid = Validator( $request->all(), array(
            'id' 	=> 'required|numeric'
        ));

        if (! $valid->fails()) {
        	$result = DB::table('members')
        				->where('id', '=', $request->input('id'))
                		->delete();

    		if ($result) {
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

        return response()->json([
            'message' => 'NG'
        ]);
	}

    public function updateMember(Request $request)
    {
        $valid = Validator( $request->all(), array(
            'id'            => 'required|numeric',
            'guestName'     => 'required|string',
            'guestPhone'    => 'required|numeric',
            'guestAddress'  => 'required|string',
        ));

        if (! $valid->fails()) {
            $guestName      = $request->input('guestName');
            $guestPhone     = $request->input('guestPhone');
            $gender         = $request->input('gender');
            $guestAddress   = $request->input('guestAddress');
            $guestNote      = $request->input('guestNote');
            
            $result = DB::table('members')
                        ->where('id', '=', $request->input('id'))
                        ->update([
                            'member_name'       => $guestName,
                            'member_phone'      => $guestPhone,
                            'is_female'         => $gender,
                            'member_address'    => $guestAddress,
                            'member_note'       => $guestNote,
                        ]);

            if ($result) {
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

        return response()->json([
            'message' => 'NG'
        ]);
    }

    public function getMember(Request $request, $id)
    {   
        echo $id;
    }
    
	public function getMembers()
	{
		$members = DB::table('members')
                    ->select(
                        'id',
                        'member_name',
                        'member_phone',
                        DB::raw('CASE is_female WHEN 0 THEN "Nam" WHEN 1 THEN "Nữ" END AS is_female'),
                        'member_address',
                        'member_note',
                        'debt'
                    )
					->get();

		return Datatables::of($members)
            ->editColumn('debt', function ($member) {
                return number_format($member->debt, 0, ",", ".");
            })
            ->make(true);
	}

    public function getMembersName(Request $request)
    {
        $search = $request->q;
        $members = DB::table('members')
                    ->select('id', 'member_name', 'member_phone')
                    ->where('member_name','LIKE',"%$search%")
                    ->get();

        return response()->json($members);
    }

    public function getDebtOfMember(Request $request)
    {
        $id = $request->input('id');
        $debt = DB::table('members')
                    ->select('debt')
                    ->where('id','=', $id)
                    ->first();

        return response()->json($debt);
    }
}
