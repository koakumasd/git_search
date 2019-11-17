<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Helpers;
class RerpositoryController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function searchRepo(Request $request)
	{
		if(!empty($request['query'])){
			$client = new \GuzzleHttp\Client(['headers'=>["Accept"=>"application/vnd.github.mercy-preview+json"]]);
			$query=$request['query'];
			$page=!empty($request['page'])?$request['page']:1;
			$results = $client->get('https://api.github.com/search/repositories?', ['query' => ['q'=>$query." in:name",'page'=>$page] ]);
			if($results->getStatusCode()==200){
				$results = json_decode($results->getBody()->getContents(),1);
				$res=[];
				$favorites=Auth::user()->favorites;
				$favorites_array=[];
				foreach ($favorites as $key => $favorite) {
					$favorites_array[]=$favorite->repo_id;
				}
				$total_pages=$results['total_count'];
				$paginate=Helpers::paginate($request->fullUrl(),$page,$total_pages,30);
				foreach ($results['items'] as $key => $result) {
					$res[]=array(
								'repo_id'=>$result['id'],
								'name'=>$result['name'],
								'html_url'=>$result['html_url'],
								'owner_login'=>$result['owner']['login'],
								'stargazers_count'=>$result['stargazers_count'],
								'is_favorite'=>in_array( $result['id'],$favorites_array)?1:false
							);
				}
				return view('home',['results'=>$res,'page'=>$page,'query'=>$query,'paginate'=>$paginate]);
			}
			
		}
		
		
	}
	public function addToFavorite(Request $request)
	{
		if ( !empty( $request->except('_token') ) ){
			$data=array(
				'repo_id'=>$request['repo_id'],
				'name'=>$request['name'],
				'html_url'=>$request['html_url'],
				'owner_login'=>$request['owner_login'],
				'stargazers_count'=>$request['stargazers_count'],
				'user_id'=>Auth::user()->id
			);
			$search_repo=\App\Favorite::where('user_id',Auth::user()->id)->where('repo_id',$request['repo_id'])->first();
			if(empty($search_repo)){
				\App\Favorite::create($data);
				echo json_encode(array('message'=>'success'));
			}
			else{
				\App\Favorite::destroy($search_repo->id);

				echo json_encode(array('message'=>'removed'));
			}
		}
		else{
			echo json_encode(array('message'=>'no data to create repository'));

		}
		
		
	}
	public function removeFromFavorite(Request $request)
	{
		if(!empty($request->repo_id)){
			$search_repo=\App\Favorite::where('user_id',Auth::user()->id)->where('repo_id',$request['repo_id'])->first();
			if(!empty($search_repo)){
				\App\Favorite::destroy($search_repo->id);
				echo json_encode(array('message'=>'success'));
			}
			else{
				echo json_encode(array('message'=>'repository not deleted'));
			}
		}
		else{
				echo json_encode(array('message'=>'no repository found'));

		}
		
	}
	public function userFavorites(Request $request)
	{
		$favorites=Auth::user()->favorites->toArray();
		return view('user_favorites',['favorites'=>$favorites]);
	}
}
