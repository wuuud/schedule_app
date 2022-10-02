<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

// アクセサとインスタンスメソッドの追加
// 更新フォームに既存データを表示する際、開始日時と終了日時を日付と時間に分割
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
        'title',
        'body',
        'start',
        'end',
    ];

    //XX時間前の表示用。一覧画面で予定までの残り時間表示用。
    public function start_diff()
    {
        return (new Carbon($this->start))->diffForHumans();
    }

    // 開始時刻の日付
    public function getStartDateAttribute()
    {
        return (new Carbon($this->start))->toDateString();
    }

    // 開始時刻の時刻
    public function getStartTimeAttribute()
    {
        return date_parse_from_format('%Y-%m-%d %H:%i', $this->start)["hour"]
            ? (new Carbon($this->start))->toTimeString()
            : '';
    }
    // 終了の日付
    public function getEndDateAttribute()
    {
        return (new Carbon($this->end))->toDateString();
    }
    // 終了の時刻
    public function getEndTimeAttribute()
    {
        return date_parse_from_format('%Y-%m-%m %H:%i', $this->end)['hour']
            ? (new Carbon($this->end))->toTimeString()
            : '';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
