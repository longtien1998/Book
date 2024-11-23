<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'code' => 'required|unique:coupons,code,' . $this->id,
        'number' => 'required|integer', 
    ];
}

public function messages(): array
{
    return [
        'name.required' => 'Tên không được để trống.',
        'code.required' => 'Mã giảm giá không được để trống.',
        'code.unique' => 'Mã giảm giá đã tồn tại trong hệ thống.',
        'number.required' => 'Nhập % or tiền giảm không được để trống.',
        'number.integer' => 'Số lượng phải là số nguyên.',
    ];
}

}
