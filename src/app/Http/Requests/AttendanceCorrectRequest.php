<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceCorrectRequest extends FormRequest
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

    public function rules()
    {
        return [
            'request_clock_in' => 'required|date_format:H:i',
            'request_clock_out' => 'required|date_format:H:i|after:request_clock_in',

            'break_start.*' => 'nullable|date_format:H:i',
            'break_end.*' => 'nullable|date_format:H:i|after:break_start.*',

            'notes' => 'required|string|max:255',
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $clockIn = $this->request_clock_in;
            $clockOut = $this->request_clock_out;

            $breakStarts = $this->break_start ?? [];
            $breakEnds = $this->break_end ?? [];

            foreach ($breakStarts as $index => $start) {
                $end = $breakEnds[$index] ?? null;

                // 開始が出勤前
                if ($start && $clockIn && $start < $clockIn) {
                    $validator->errors()->add(
                        "break_start.$index",
                        '休憩時間が不適切な値です'
                    );
                }

                // 開始が退勤後
                if ($start && $clockOut && $start > $clockOut) {
                    $validator->errors()->add(
                        "break_start.$index",
                        '休憩時間が不適切な値です'
                    );
                }

                // 終了が出勤前
                if ($end && $clockIn && $end < $clockIn) {
                    $validator->errors()->add(
                        "break_end.$index",
                        '休憩時間が不適切な値です'
                    );
                }

                // 終了が退勤後
                if ($end && $clockOut && $end > $clockOut) {
                    $validator->errors()->add(
                        "break_end.$index",
                        '休憩時間が不適切な値です'
                    );
                }
            }
        });
    }

    public function messages()
    {
        return [
            'request_clock_in.required' => '出勤時刻を入力してください。',
            'request_clock_out.required' => '退勤時刻を入力してください。',
            'request_clock_out.after' => '出勤時間もしくは退勤時間が不適切な値です',

            'break_end.*.after' => '休憩時間が不適切な値です',

            'notes.required' => '備考を記入してください',
        ];
    }
}
