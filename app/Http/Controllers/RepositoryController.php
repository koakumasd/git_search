<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Helpers;
use App\Http\Requests\StoreRepository;
use App\Http\Requests\RemoveRepository;
use App\Http\Requests\SearchRepository;


class RepositoryController extends Controller 
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function searchRepo(SearchRepository $request) {
        $client = new \GuzzleHttp\Client(
            [
                'headers' =>
                    ["Accept" => "application/vnd.github.mercy-preview+json"]
             ]
        );
        $query = $request['query'];
        $page = !empty($request['page']) ? $request['page'] : 1;
        $results = $client->get(
                'https://api.github.com/search/repositories?',
                [
                    'query' => [
                        'q' => $query . " in:name", 'page' => $page
                    ]
                ]
        );

        if ($results->getStatusCode() == 200) {
            $results = json_decode($results->getBody()->getContents(), 1);
            $res = [];
            $favorites = Auth::user()->favorites->pluck('repo_id')->toArray();
            $total_pages = $results['total_count'];
            $paginate = Helpers::paginate(
                $request->getPathInfo(), 
                $request->getQueryString(), 
                $total_pages, 30
            );
            $repositories = collect();
            foreach ($results['items'] as $result) {
                $repositories->push([
                    'repo_id' => $result['id'],
                    'name' => $result['name'],
                    'html_url' => $result['html_url'],
                    'owner_login' => $result['owner']['login'],
                    'stargazers_count' => $result['stargazers_count'],
                    'is_favorite' => in_array($result['id'], $favorites) ? 1 : false
                ]);
            }
            
            return view('home',compact('repositories','page','query','paginate'));
        }
    }

    public function addToFavorite(StoreRepository $request) {
        $data = [
            'repo_id' => $request['repo_id'],
            'name' => $request['name'],
            'html_url' => $request['html_url'],
            'owner_login' => $request['owner_login'],
            'stargazers_count' => $request['stargazers_count'],
            'user_id' => Auth::user()->id
        ];

        $search_repo = \App\Favorite::where('user_id', Auth::user()->id)
                ->where('repo_id', $request['repo_id'])
                ->first();
        if (empty($search_repo)) {
            \App\Favorite::create($data);
            return ['message' => 'success'];
        } else {
            return ['message' => 'no data to create repository'];
        }
    }

    public function removeFromFavorite(RemoveRepository $request) {
        $search_repo = \App\Favorite::where('user_id', Auth::user()->id)
                ->where('repo_id', $request['repo_id'])
                ->first();
        if (!empty($search_repo)) {
            \App\Favorite::destroy($search_repo->id);
            return ['message' => 'success'];
        } else {
            return ['message' => 'no repository found'];
        }
        
    }

    public function userFavorites() {
        $favorites = \App\Favorite::where('user_id',Auth::user()->id)->paginate(30);
        return view('user_favorites', compact('favorites'));
    }

}
