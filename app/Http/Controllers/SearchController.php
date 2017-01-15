<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;

class SearchController extends Controller
{
    public function search(Request $request, string $search_term = null)
    {
        $search_term = trim($search_term);

        if (empty($search_term) && !empty(trim($request->q))) {
            return redirect()->route('search', trim($request->q));
        }

        $results = [
            'users' => [],
            'messages' => [],
        ];

        if ($search_term) {
            $results['users'] = User::select('id', 'email', 'name', 'username', 'bio', 'website')->where('name', 'LIKE', '%' . $search_term . '%')->orWhere('username', 'LIKE', '%' . $search_term . '%')->orWhere('bio', 'LIKE', '%' . $search_term . '%')->paginate(10);
            $results['messages'] = Message::select('id', 'user_id', 'body', 'answer', 'answered_at')->where('status_id', Message::STATUS_ANSWERED_PUBLICLY)->where(function($query) use ($search_term) {
                $query->where('body', 'LIKE', '%' . $search_term . '%')->orWhere('answer', 'LIKE', '%' . $search_term . '%');
            })->paginate(10);
        }

        return view('search.results', ['title' =>  'Search results', 'page' => 'search', 'search_term' => $search_term, 'results' => $results]);
    }
}
