<?php

namespace App\Http\Controllers;

use App\Models\Money;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MoneyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Carbon::setLocale('id_ID');
    }

    public function index()
    {
        $user = Auth::user();

        $money = Money::whereUserId($user->id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get()
            ->map(function ($el) {
                $el->type = Str::remove('_of_month', $el->type);

                return $el;
            })
            ->groupBy(function ($el) {
                return $el->month_year;
            });

        return $this->success(data: $money);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|digits:4',
            'type' => 'required|in:start_of_month,end_of_month',
        ]);

        $userId = Auth::id();
        $type = $request->type;
        if ($type == 'end_of_month') {
            $date = Carbon::parse("{$request->year}-{$request->month}-1")->startOfDay()->endOfMonth();
        } else {
            $date = Carbon::parse("{$request->year}-{$request->month}-1")->startOfDay()->startOfMonth();
        }

        $money = Money::where('month', $request->month)
            ->where('year', $request->year)
            ->where('type', $type)
            ->where('user_id', $userId)
            ->first();

        if (!isset($money)) {
            $money = new Money();
        }
        $money->user_id = $userId;
        $money->amount = $request->amount;
        $money->year = $date->year;
        $money->month = $date->month;
        $money->type = $type;
        $money->save();

        return response()->json(['money' => $money]);
    }

    public function report()
    {
        $user = Auth::user();
        $moneys = Money::where('user_id', $user->id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        $res = [];
        foreach ($moneys as $key => $value) {
            $startEnd = Str::remove('_of_month', $value->type);

            $res[$value->month_year][$startEnd] = $value->amount;
        }

        foreach ($res as $date => $r) {
            $start = $r['start'] ?? 0;
            $end = $r['end'] ?? 0;

            if ($start != 0 && $end != 0) {
                $res[$date]['diff'] = numbFormat($end - $start);
            } else {
                $res[$date]['diff'] = '0';
            }
            $res[$date]['start'] = numbFormat($start);
            $res[$date]['end'] = numbFormat($end);
        }

        return $this->json($res);
    }
}
