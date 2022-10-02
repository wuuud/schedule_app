<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class FullCalendarController extends Controller
// ログインしているユーザーの情報を取得します。 
// その他の条件として、FullCalendaは表示する期間の情報も
// 付与してアクセスしてくるので、その条件で絞り込み
{
    // 取得した期間の情報を送ってくるのでrequest
    public function index(Request $request)
    {
        // startとendのカラムは文字列で保存されているので、
        // where(カラム, '>=' , 期間)では絞り込めません。 
        // 代わりにwhereDate()を使うことで、データを日付として絞り込めます。
        //                        一致
        $data = Event::where('user_id', $request->user()->id)
        // 　　　　　　　　　　　日付として絞り込み
            ->whereDate('start', '>=', $request->start)
            ->whereDate('end',   '<=', $request->end)
            // 取りたいカラムを記載。必ず記載すること！
            // パスワードなどがネット上で見えてしまうかも！
            ->get(['id', 'title', 'body', 'start', 'end']);

        return response()->json($data);
    }

    
    public function action(Request $request)
    {
        if ($request->type == 'add') {
            $event = new Event($request->all());
            $event->user_id = $request->user()->id;
            $event->save();

            return response()->json($event);
        }

        if ($request->type == 'update') {
            $event = Event::find($request->id);
            $event->fill($request->all());
            $event->save();

            return response()->json($event);
        }

        if ($request->type == 'delete') {
            $event = Event::find($request->id);
            $event->delete();

            return response()->json($event);
        }
    }
}
