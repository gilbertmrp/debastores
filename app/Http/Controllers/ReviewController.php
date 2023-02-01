<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index() {
        $reviewer = Pesanan::where('status', 6)->get();
        return view('user.review', [
            "title" => 'Review'
        ], compact('reviewer'));
    }

    public function store($id) {
        $feedback = Pesanan::where('id', $id)->first();
        return view('user.feedback', [
            "title" => 'Berikan Ulasan'
        ], compact('feedback'));
    }

    // public function storeProcess(Request $request, $id) {
    //     $request->validate([
    //         'review' => 'required',
    //         'img2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'video' => 'nullable|mimes:mp4,ogx,oga,ogv,ogg,webm'
    //     ]);

    //     $reviewForm = Pesanan::where('id', $id)->first();
    //     if($request->hasFile('img2')) {
    //         $request->file('img2')->move('productimage/', $request->file('img2')->getClientOriginalName());
    //         $reviewForm->img2 = $request->file('img2')->getClientOriginalName();
    //     }
    //     $file = $request->file('video');
    //     $file->move('upload',$file->getClientOriginalName());
    //     $file_name=$file->getClientOriginalName();
    //     $reviewForm->video = $file_name;
    //     $reviewForm->review = $request->review;
    //     $reviewForm->status = 6;
    //     $reviewForm->update();
    //     return redirect()->route('history.detail')->with('toast_success', 'Ulasan anda telah tersimpan!');
    // }

    public function storeReviewProcess(Request $request, $id) {
        $request->validate([
            'img2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|mimes:mp4,ogx,oga,ogv,ogg,webm',
            'review' => 'required|String|min:3'
        ]);

        $reviewers = Pesanan::where('id', $id)->first();
        if($request->hasFile('img2')) {
            $request->file('img2')->move('productimage/', $request->file('img2')->getClientOriginalName());
            $reviewers->img2 = $request->file('img2')->getClientOriginalName();
        }
        if($request->hasFile('video')) {
            $request->file('video')->move('upload/', $request->file('video')->getClientOriginalName());
            $reviewers->video = $request->file('video')->getClientOriginalName();
        }
        $reviewers->review = $request->review;
        $reviewers->status = 6;
        $reviewers->save();
        return redirect()->route('review')->with('toast_success', 'Your review has been saved');
    }
}
