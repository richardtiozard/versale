<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Feedback;
use Auth;

class FeedbackController extends Controller
{
    public function index(){
        $feedbacks = DB::table('feedback')
                        ->select(
                            'feedback.id as feedback_id' , 'feedback.title as feedback_title' , 'feedback.message as feedback_message' , 'feedback.status as feedback_status' , 
                            'users.id as user_id' , 'users.email as user_email' , 'users.role as user_role'
                        )
                        ->leftjoin('users', 'users.id', 'feedback.user_id')
                        ->orderByDesc('feedback.created_at')
                        ->get();

        $data = [
            'feedbacks' => $feedbacks,
        ];

        return view('feedback.index', ['data' => $data]);
    }

    public function create(){
        if ( Auth::user()->role == 'admin'){
            return redirect()->route('home');
        }
        return view('feedback.create');
    }

    public function store(Request $request){
        $feedback = new Feedback;
        $feedback->user_id = Auth::user()->id;
        $feedback->title = $request->title;
        $feedback->message = $request->message;
        $feedback->status = 'Pending';
        $feedback->save();
        return view('feedback.create');
    }

    public function update(Request $request){
        $feedback = Feedback::find($request->feedback_id);
        $feedback->status = 'Closed';
        $feedback->save();

        return 'success';
    }
}
