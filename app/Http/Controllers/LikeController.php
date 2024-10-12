<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index(Request $request)
    {
        $produk_id = $request->input('produk_id');
        $user_id = auth()->user()->id;

        $data = [
            'user_id' => $user_id,
            'produk_id' => $produk_id
        ];

        $query = Like::where($data);

        if ($query->count() > 0) {
            $query->delete();
            $likeStatus = 'unliked';
        } else {
            Like::create($data);
            $likeStatus = 'liked';
        }

        $likeCount = Like::where('produk_id', $produk_id)->count();

        return response()->json([
            'status' => $likeStatus,
            'likeCount' => $likeCount
        ]);
    }
}
