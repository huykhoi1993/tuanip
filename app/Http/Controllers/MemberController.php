<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class MemberController extends Controller
{
    public function index()
	{
		return view('admin.members');
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

	public function getMembers()
	{
		$members = DB::table('members')
					->get();

		return Datatables::of($members)
            ->editColumn('is_female', function ($member) {
                return $member->is_female ? 'Nữ' : 'Nam';
            })
            ->make();
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
}
