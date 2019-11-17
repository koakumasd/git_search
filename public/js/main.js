jQuery('.favorite').click(function(){
		var repo_id=jQuery(this).attr('repo_id');
		var name=jQuery(this).attr('name');
		var html_url=jQuery(this).attr('html_url');
		var owner_login=jQuery(this).attr('owner_login');
		var stargazers_count=jQuery(this).attr('stargazers_count');
		var button =this
		var data={
			'repo_id':repo_id,
			'name':name,
			'html_url':html_url,
			'owner_login':owner_login,
			'stargazers_count':stargazers_count,
			 '_token':jQuery('meta[name="csrf-token"]').attr('content'),
			};
	

	jQuery.ajax({
		url: '/add_to_favorite',
		method: 'post',
		dataType: 'json',
		data: data,
		success:function(response){
			if(response.message=='success'){
				jQuery(button).find('i').removeClass('fa-heart-o').addClass('fa-heart')
			}
			else if(response.message=='removed'){
				if(jQuery(button).hasClass('search')){
					jQuery(button).find('i').removeClass('fa-heart').addClass('fa-heart-o')
				}
				else if(jQuery(button).hasClass('user')){
					jQuery(button).closest('tr').remove();
				}
			}
			
		}

	});
	
})

jQuery('.remove-fav-user').click(function(){
	var repo_id=jQuery(this).attr('repo_id');
	var button =this
	var data={
			'repo_id':repo_id,
			 '_token':jQuery('meta[name="csrf-token"]').attr('content')
		}
	jQuery.ajax({
		url: '/remove_from_favorite',
		method: 'post',
		dataType: 'json',
		data: data,
		success:function(response){
			if(response.message=='success'){
				jQuery(button).closest('tr').remove();
			}
		}

	});
	
});

