<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Datatables;

class DebitController extends Controller
{
    public function index()
    {
    	return view('admin.debits');
    }

    public function store(Request $request)
    {
        $valid = Validator( $request->all(), array(
            'id'        => 'required|numeric',
            'payMoney'  => 'required|numeric',
            'isDebit'   => 'required|numeric',
            'done'      => 'required|numeric',
        ));

        if (! $valid->fails() ) {
            $member_id  = $request->input('id');
            $payMoney   = $request->input('payMoney');
            $isDebit    = $request->input('isDebit');
            $done       = $request->input('done');
            $datedone   = $request->input('dateDone');
            $note       = $request->input('note');


            if ( $isDebit == 1) {
                DB::table('debits')
                    ->insert([
                        'member_id'     => $member_id,
                        'total_amount'  => $payMoney,
                        'is_dedit'      => 1,
                        'pay_done'      => $done,
                        'debit_note'    => $note,
                        'created_at'    => Carbon::createFromFormat('d/m/Y', $datedone)->toDateString(),
                        'updated_at'    => Carbon::createFromFormat('d/m/Y', $datedone)->toDateString(),
                    ]);

                if ( $done == 1) {
                    $money = DB::table('members')
                        ->select('debt')
                        ->where([
                            ['id', '=', $member_id]
                        ])
                        ->first();

                    DB::table('members')
                        ->where([
                            ['id', '=', $member_id]
                        ])
                        ->update([
                            'debt'          => ($money->debt - $payMoney),
                            'updated_at'    => Carbon::now()
                        ]);
                }

                return response()->json([
                    'message' => 'OK'
                ]);
            }
            elseif ( $isDebit == 0) {
                DB::table('debits')
                    ->insert([
                        'member_id'     => $member_id,
                        'total_amount'  => $payMoney,
                        'is_dedit'      => 0,
                        'pay_done'      => $done,
                        'debit_note'    => $note,
                        'created_at'    => Carbon::createFromFormat('d/m/Y', $datedone)->toDateString(),
                        'updated_at'    => Carbon::createFromFormat('d/m/Y', $datedone)->toDateString(),
                    ]);

                if ( $done == 1) {
                    $money = DB::table('members')
                        ->select('debt')
                        ->where([
                            ['id', '=', $member_id]
                        ])
                        ->first();

                    DB::table('members')
                        ->where([
                            ['id', '=', $member_id]
                        ])
                        ->update([
                            'debt'          => ($money->debt + $payMoney),
                            'updated_at'    => Carbon::now()
                        ]);
                }

                return response()->json([
                    'message' => 'OK'
                ]);
            }
        } 
    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function getDebits()
    {
        $debits = DB::table('debits')
                    ->join('members', 'members.id', '=', 'debits.member_id')
                    ->select(
                        'debits.id',
                        'members.member_name',
                        'members.member_phone',
                        'debits.total_amount',
                        'debits.is_dedit',
                        'debits.pay_done',
                        'debits.debit_note',
                        'debits.created_at'
                    )
                    ->get();

        // return response()->json($debits);
        return Datatables::of($debits)
            ->editColumn('total_amount', function ($depot) {
                return number_format($depot->total_amount, 0, ",", ".");
            })
            ->editColumn('is_dedit', function ($debit) {
                return $debit->is_dedit == 1 ? 'Nợ' : 'Công';
            })
            ->editColumn('pay_done', function ($debit) {
                return $debit->pay_done == 1 ? 'Đã thanh toán' : 'Chưa';
            })
            ->editColumn('member_name', function ($debit) {
                return $debit->member_phone ? $debit->member_name . ' (' . $debit->member_phone . ')' : $debit->member_name;
            })
            ->removeColumn('member_phone')
            ->make();
    }
}
