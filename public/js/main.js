jQuery('body').on('click','.favorite.add',function(){
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
                    jQuery(button).removeClass('add').addClass('remove')
                }
            },
            error:function(response){
                if(response.status==422){
                    console.log(response.responseJSON)
                }
            }
	});
})

jQuery('body').on('click','.favorite.remove',function(){
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
                    if(jQuery(button).hasClass('search')){
                        jQuery(button).removeClass('remove').addClass('add')
                        jQuery(button).find('i').addClass('fa-heart-o').removeClass('fa-heart')

                    }
                    else{
                        jQuery(button).closest('tr').remove();
                    }
                }
            }
	});
});

