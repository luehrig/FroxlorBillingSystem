$(function(){
	
	$(document).ready(function(){
		
		$('.lightbox').click(function(){
			$('.backdrop, .box').animate({'opacity':'.70'}, 300, 'linear');
			$('.box').animate({'opacity':'1.00'}, 300, 'linear');
			$('.backdrop, .box').css('display', 'block');
		});
		
		$('.close').click(function(){
			close_box();
		});
		
		$('.backdrop').click(function(){
			close_box();
		});
		
	});
	
	function close_box()
	{
		$('.backdrop, .box').animate({'opacity':'0'}, 300, 'linear', function(){
			$('.backdrop, .box').css('display', 'none');
		});
	}
	
});