<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
    protected function prepareForValidation()
    {
        // thisはrequest
        // start_date', 'start_time用意したデータの構文　２つがあるか
        $start = ($this->filled(['start_date', 'start_time'])) 
        //両者があれば  　　　　　　　　　両者を結合
        // 　　　　　　　　2022-10-02          10:00:00
                ? $this->start_date . ' ' . $this->start_time : '';
        $end = ($this->filled(['end_date', 'end_time'])) 
                ? $this->end_date . ' ' . $this->end_time : '';
        
        $this->merge([
            // 今作った配列に追加して
            // 結合したものにバリデーションが効く
            // 上記の＄startは上記の式でしか生きられないので
            // ここに入ってねと指示
            'start' => $start,
            'end' => $end,
        ]);
    }
}
