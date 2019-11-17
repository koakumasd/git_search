<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helpers
{
    /**
      * Get user role name
      *
      * $return string
      */
    public static function paginate($url, $page,$total,$per_page)
    {
		if($total>$per_page){
			$url_arr=parse_url ($url);
			$pagination=' <nav><ul class="pagination">';
			$path=$url_arr['path'];
			$total_pages=intval($total/$per_page);
			$to_display=range($page-3,$page+3);
			$prev_number=$page!=1?$page-1:1;
			$next_number=$page!=$total_pages?$page+1:$total_pages;
			if(!empty($url_arr['query']) && strpos($url_arr['query'], 'page=')!==false){
				$prev_url=$path."?".str_replace("page=$page","page=$next_number",$url_arr['query']);
				$back_url=$path."?".str_replace("page=$page","page=$prev_number",$url_arr['query']);
			}
			else{
				$prev_url=$path."?".$url_arr['query']."&page=$next_number";
				$back_url=$path."?".$url_arr['query']."&page=$prev_number";
			}
			if($page!=1){
				$pagination.="<li class='page-item'><a class='page-link' href='$back_url'>Previous</a></li>";
			}
			for ($i=1; $i <=$total_pages ; $i++) {
				$class=intval($page)==$i?"active":'';
				if(!empty($url_arr['query']) && strpos($url_arr['query'], 'page=')!==false)
					$new_url=$path."?".str_replace("page=$page","page=$i",$url_arr['query']);
				else{
					$new_url=$path."?".$url_arr['query']."&page=$i&";
				}
				if(array_search($i,$to_display)!==false){
					$pagination.="<li class='page-item $class'><a class='page-link' href='$new_url'>$i</a></li>";
				}
			}
			if($page!=$total_pages){
				$pagination.="<li class='page-item'><a class='page-link' href='$prev_url'>Next</a></li>";
			}
			$pagination.='</ul></nav>';
			return $pagination;
		}
	}
}
