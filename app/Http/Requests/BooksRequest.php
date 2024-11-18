<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BooksRequest extends FormRequest
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
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'availability_status' => 'required',
            'category_id' => 'required|exists:categories,id',
            'publication_year' => 'required|date|before_or_equal:today',
            'publisher' => 'nullable|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
            'isbn' => 'required|string|max:20|unique:books,isbn,'.$this->id,
            'language' => 'required|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048', // tối đa 2MB
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Tên sách không được bỏ trống.',
            'title.max' => 'Tên sách không được vượt quá 255 ký tự.',
            'author.required' => 'Tác giả không được bỏ trống.',
            'author.max' => 'Tác giả không được vượt quá 255 ký tự.',
            'price.required' => 'Giá sách không được bỏ trống.',
            'price.numeric' => 'Giá sách phải là một số.',
            'price.min' => 'Giá sách không được nhỏ hơn 0.',
            'availability_status.required' => 'Trạng thái sẵn có là bắt buộc.',
            'category_id.required' => 'Danh mục không được để trống.',
            'category_id.exists' => 'Danh mục không tồn tại.',
            'publication_year.required' => 'Ngày xuất bản không được để trống.',
            'publication_year.date' => 'Ngày xuất bản phải là một định dạng ngày hợp lệ.',
            'publication_year.before_or_equal' => 'Ngày xuất bản không được vượt quá ngày hiện tại.',
            'publisher.max' => 'Nhà xuất bản không được vượt quá 255 ký tự.',
            'stock_quantity.required' => 'Số lượng tồn kho không được để trống.',
            'stock_quantity.integer' => 'Số lượng tồn kho phải là một số nguyên.',
            'stock_quantity.min' => 'Số lượng tồn kho không được nhỏ hơn 0.',
            'isbn.required' => 'Mã ISBN không được để trống.',
            'isbn.max' => 'Mã ISBN không được vượt quá 20 ký tự.',
            'isbn.unique' => 'Mã ISBN đã tồn tại.',
            'language.required' => 'Ngôn ngữ không được để trống.',
            'language.max' => 'Ngôn ngữ không được vượt quá 255 ký tự.',
            'image_url.image' => 'Ảnh phải là tệp hình ảnh.',
            'image_url.mimes' => 'Ảnh phải có định dạng jpeg, jpg, png hoặc gif.',
            'image_url.max' => 'Kích thước ảnh không được vượt quá 2MB.',
        ];
    }
}
