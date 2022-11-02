<?php

namespace App\Http\Controllers;
use App\Idea;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Operation;

class OperationController extends Controller
{
    //
    public function index()
    {
        $likes = Operation::all();
        if($likes->isEmpty()){
            $like = new Operation();
            $like->number_of_likes_for_featured = 100;
            $like->save();
            $number_of_likes = $like->number_of_likes_for_featured;
        }else{
            $number_of_likes = $likes[0]->number_of_likes_for_featured;
        }
        
        return view('settings.index',compact('number_of_likes'));
    }

    public function amounOfLike(Request $request)
    {
        $likes = Operation::all();
        $likes[0]->number_of_likes_for_featured = $request->number;
        $likes[0]->save();
        laraflash()->message('New Amount set successfully !' . Carbon::now()->format('F j, Y, g:i A'))->success();
        return redirect()->back();
    }
    public function makeFeaturedByLikes(Request $request)
    {
        $likes = Operation::all();
        $number_of_likes_for_featured = $likes[0]->number_of_likes_for_featured;
        $ideas = Idea::with('likes')->get();
        $count = 0;
        foreach ($ideas as $idea) {
            if ($idea->likes->count() >= $number_of_likes_for_featured){
                if($idea->is_featured == 0){
                    $idea->is_featured = 1;
                    $idea->save();
                    $count++;
                }
            }
        }
        // return $ideas[0]->likes->count();
        if($count){
            laraflash()->message(' ideas ('.$count.') having more than '.$number_of_likes_for_featured.' likes, featured successfully  ! ' . Carbon::now()->format('F j, Y, g:i A'))->success();
        }else{
            laraflash()->message('No idea found having more than '.$number_of_likes_for_featured.' likes & unfeatured ! ')->info();
        }

        return redirect()->back();

    }



}
