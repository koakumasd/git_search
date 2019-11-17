<?php 
	function paginate($url, $page,$total,$per_page){
		if($total>$per_page){
			$url_arr=parse_url ($url);
			$pagination=' <nav><ul class="pagination">';
			$path=$url_arr['path'];
			$total_pages=intval($total/$per_page);
			$to_display=range($page-3,$page+3);
			$b=$page!=1?$page-1:1;
			$f=$page!=$total_pages?$page+1:$total_pages;
			if(!empty($url_arr['query']) && strpos($url_arr['query'], 'page=')!==false){
				$f_url=$path."?".str_replace("page=$page","page=$f",$url_arr['query']);
				$b_url=$path."?".str_replace("page=$page","page=$b",$url_arr['query']);
			}
			else{
				$f_url=$path."?page=$f";
				$b_url=$path."?page=$b";
			}
			if($page!=1){
				$pagination.="<li class='page-item'><a class='page-link' href='$b_url'>Previous</a></li>";
			}
			for ($i=1; $i <=$total_pages ; $i++) {
				$class=intval($page)==$i?"active":'';
				if(!empty($url_arr['query']) && strpos($url_arr['query'], 'page=')!==false)
					$new_url=$path."?".str_replace("page=$page","page=$i",$url_arr['query']);
				else{
					$new_url=$path."?page=$i";
				}
				if(array_search($i,$to_display)!==false){
					$pagination.="<li class='page-item $class'><a class='page-link' href='$new_url'>$i</a></li>";
				}
			}
			if($page!=$total_pages){
				$pagination.="<li class='page-item'><a class='page-link' href='$f_url'>Next</a></li>";
			}
			$pagination.='</ul></nav>';
			return $pagination;
		}
	}