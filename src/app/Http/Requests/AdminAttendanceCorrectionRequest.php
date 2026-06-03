<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminAttendanceCorrectionRequest extends FormRequest
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
        return 
        [
            'request_clock_in' => ['required'],
            'request_clock_out' => ['required'],

            'break_start.*' => ['nullable'],
            'break_end.*' => ['nullable'],

            'notes' => ['nullable', 'string'],
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $clockIn = $this->request_clock_in;
            $clockOut = $this->request_clock_out;

            // 出勤 > 退勤
            if ($clockIn && $clockOut && $clockIn >= $clockOut) {
                $validator->errors()->add(
                    'request_clock_in',
                    '出勤時間もしくは退勤時間が不適切な値です'
                );
            }

            foreach ($this->break_start ?? [] as $index => $start) {
                $end = $this->break_end[$index] ?? null;

                // 休憩開始
                if (
                    $start &&
                    (
                        ($clockIn && $start < $clockIn) ||
                        ($clockOut && $start > $clockOut)
                    )
                ) {
                    $validator->errors()->add(
                        "break_start.$index",
                        '休憩時間が不適切な値です'
                    );
                }

                // 休憩終了
                if (
                    $end &&
                    $clockOut &&
                    $end > $clockOut
                ) {
                    $validator->errors()->add(
                        "break_end.$index",
                        '休憩時間もしくは退勤時間が不適切な値です'
                    );
                }
            }
        });
    }
}
