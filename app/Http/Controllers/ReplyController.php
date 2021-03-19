<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ReplyController extends Controller
{
    public function index(User $user)
    {
        $replies = $user->replies()->latest()->paginate(5);
        return view('users.replies.index', compact('replies'));
    }
}
