<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'image_path' => 'required|image|mimes:jpg,png,gif,jpeg|max:10000',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ];
    }
    public function messages(){
        return [
            'title.required' => 'Tên không được để trống',
            'title.max' => 'Tên không được quá 255 ký tự',
            'image_path.required' => 'Hình ảnh không được để trống',
            'image_path.mimes' => 'Hình ảnh phải là file jpeg, jpg, gif hoặc png',
            'image_path.max' => 'Hình ảnh không được quá 10MB',
            'description.max' => 'Mô tả không được quá 255 ký tự',
            'url.url' => 'Đường dẫn không đúng định dạng',
            'start_date.required' => 'Ngày bắt đầu không được để trống',
            'start_date.date' => 'Ngày bắt đầu không đúng định dạng',
            'end_date.required' => 'Ngày kết thúc không được để trống',
            'end_date.date' => 'Ngày kết thúc không đúng định dạng',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu'
        ];
    }
}
