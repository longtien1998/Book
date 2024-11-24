<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
   // Lấy danh sách bình luận theo sách
   public function getBookComments($bookId)
   {
       $comments = Comment::with('user')
           ->where('book_id', $bookId)
           ->orderBy('created_at', 'desc')
           ->paginate(10);

       return response()->json([
           'status' => 'success',
           'data' => $comments
       ]);
   }

   // Tạo bình luận mới
   public function store(CommentRequest $request)
   {
       $comment = Comment::create([
           'user_id' => auth()->id(),
           'book_id' => $request->book_id,
           'content' => $request->content,
           'rating' => $request->rating
       ]);

       return response()->json([
           'status' => 'success',
           'message' => 'Bình luận đã được tạo thành công',
           'data' => $comment->load('user')
       ], 201);
   }

   // Cập nhật bình luận
   public function update(CommentRequest $request, $id)
   {
       $comment = Comment::findOrFail($id);

       // Kiểm tra xem người dùng có quyền sửa bình luận không
       if ($comment->user_id !== auth()->id()) {
           return response()->json([
               'status' => 'error',
               'message' => 'Bạn không có quyền sửa bình luận này'
           ], 403);
       }

       $comment->update([
           'content' => $request->content,
           'rating' => $request->rating
       ]);

       return response()->json([
           'status' => 'success',
           'message' => 'Bình luận đã được cập nhật',
           'data' => $comment
       ]);
   }

   // Xóa bình luận
   public function destroy($id)
   {
       $comment = Comment::findOrFail($id);

       if ($comment->user_id !== auth()->id()) {
           return response()->json([
               'status' => 'error',
               'message' => 'Bạn không có quyền xóa bình luận này'
           ], 403);
       }

       $comment->delete();

       return response()->json([
           'status' => 'success',
           'message' => 'Bình luận đã được xóa'
       ]);
   }
}
