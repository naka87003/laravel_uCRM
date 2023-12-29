<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DecileService
{
    public static function decile($subQuery)
    {
        // 1. 購買ID毎にまとめる
        // 2. 会員毎にまとめて購入金額順にソートする
        $subQuery->groupBy('customer_id', 'customer_name')
            ->selectRaw('customer_id, customer_name, sum(subtotal) as total')
            ->orderBy('total', 'desc');

        // statementで変数を設定できる
        // set @変数名 = 値 (mysqlの書き方)
        // 3. 購入順に連番を振る
        $subQuery = DB::table($subQuery, 'sub')
            ->selectRaw('@row_num:= @row_num+1 as row_num,customer_id,customer_name,total');

        // 4. 全体の件数を数え、1/10の値や合計金額を取得
        DB::statement('SET @row_num = 0;');
        $count = DB::table($subQuery, 'sub')->count();
        DB::statement('SET @row_num = 0;');
        $total = DB::table($subQuery, 'sub')->selectRaw('sum(total) as total')->get();

        $total = $total[0]->total; // 構成比用
        $decile = ceil($count / 10); // 10分の1の件数を変数に入れる
        $bindValues = [];
        $tempValue = 0;
        for ($i = 1; $i <= 10; $i++) {
            array_push($bindValues, 1 + $tempValue);
            $tempValue += $decile;
            array_push($bindValues, 1 + $tempValue);
        }

        // 5 10分割しグループ毎に数字を振る
        DB::statement('SET @row_num = 0;');
        $subQuery = DB::table($subQuery)
            ->selectRaw("row_num, customer_id, customer_name, total, 
            case
                when ? <= row_num and row_num < ? then 1
                when ? <= row_num and row_num < ? then 2
                when ? <= row_num and row_num < ? then 3
                when ? <= row_num and row_num < ? then 4
                when ? <= row_num and row_num < ? then 5
                when ? <= row_num and row_num < ? then 6
                when ? <= row_num and row_num < ? then 7
                when ? <= row_num and row_num < ? then 8
                when ? <= row_num and row_num < ? then 9
                when ? <= row_num and row_num < ? then 10
            end as decile", $bindValues); // SelectRaw第二引数にバインドしたい数値(配列)をいれる

        // round, avg はmysqlの関数
        // 6. グループ毎の合計・平均
        $subQuery = DB::table($subQuery, 'sub')
            ->groupBy('decile')
            ->selectRaw('decile, round(avg(total)) as average, sum(total) as totalPerGroup');

        // 7 構成比
        DB::statement("SET @total = {$total};");
        $data = DB::table($subQuery, 'sub')
            ->selectRaw('decile, average, totalPerGroup,
                round(100 * totalPerGroup / @total, 1) as totalRatio')
            ->get();

        $labels = $data->pluck('decile');
        $totals = $data->pluck('totalPerGroup');
        return [$data, $labels, $totals]; //複数の変数を渡すので一旦配列に入れる
    }
}
