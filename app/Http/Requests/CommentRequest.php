<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
    public function rules()
    {
        return [
            'book_id' => 'required|exists:books,id',
            'content' => 'required|string|max:1000',
            // 'rating' => 'required|integer|min:1|max:5'
        ];
    }

    public function messages()
    {
        return [
            'book_id.required' => 'ID sách là bắt buộc',
            'book_id.exists' => 'Sách không tồn tại',
            'content.required' => 'Bạn chưa nhập nội dung bình luận',
            'content.max' => 'Nội dung bình luận không được vượt quá 1000 ký tự',
            // 'rating.required' => 'Đánh giá sao là bắt buộc',
            // 'rating.min' => 'Đánh giá tối thiểu là 1 sao',
            // 'rating.max' => 'Đánh giá tối đa là 5 sao'
        ];
    }
}
