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
        $results = DB::table('debits')
                    ->select(
                        DB::raw('sum(case when is_debit = 0 then total_amount else 0 end) as total_credit'),
                        DB::raw('sum(case when is_debit = 0 and pay_done = 0 then total_amount else 0 end) as total_credit_no_pay'),
                        DB::raw('sum(case when is_debit = 1 then total_amount else 0 end) as total_dedit'),
                        DB::raw('sum(case when is_debit = 1 and pay_done = 0 then total_amount else 0 end) as total_dedit_no_pay')
                    )
                    ->get();

        // return $results;            
    	return view('admin.debits',[
                'total_credit'          => number_format($results[0]->total_credit, 0, ",", "."),
                'total_credit_no_pay'   => number_format($results[0]->total_credit_no_pay, 0, ",", "."),
                'total_dedit'           => number_format(-$results[0]->total_dedit, 0, ",", "."),
                'total_dedit_no_pay'    => number_format(-$results[0]->total_dedit_no_pay, 0, ",", ".")
            ]);
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
                        'is_debit'      => 1,
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
                        'is_debit'      => 0,
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

    public function getDebits(Request $request)
    {
        $debits = DB::table('debits')
                    ->join('members', 'members.id', '=', 'debits.member_id')
                    ->select(
                        'debits.id',
                        DB::raw("CONCAT(members.member_name,' - (',members.member_phone, ')') as member_name"),
                        'debits.total_amount',
                        DB::raw('CASE debits.is_debit WHEN 0 THEN "Công" WHEN 1 THEN "Nợ" END AS is_debit'),
                        DB::raw('CASE debits.pay_done WHEN 0 THEN "Chưa" WHEN 1 THEN "Đã thanh toán" END AS pay_done'),
                        'debits.debit_note',
                        DB::raw("DATE_FORMAT(debits.created_at, '%d/%m/%Y') AS created_at")
                    )
                    ->get();

        $datatables = Datatables::of($debits)
            ->editColumn('total_amount', function ($depot) {
                return number_format($depot->total_amount, 0, ",", ".");
            })
            ->editColumn('is_debit', function ($debit) {
                return $debit->is_debit != 'Công' ? 'Nợ' : '<b>' . $debit->is_debit .'</b>';
            })
            ->removeColumn('member_phone')
            ->rawColumns(['is_debit'])
            ->make(true);

        return $datatables;
    }
}
