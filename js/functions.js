$(document).ready(function(){
	$('.slideBox').cycle({
		fx: 'scrollHorz',
		activePagerClass: 'activeNavBtn',
		pager: $(".slideNav"), 
		pagerAnchorBuilder: function(index, el) {
			return '<a href="#"> </a>';
		}
	});
	
	$(".psbTabs a").click(function(){
		$(this).addClass('activeTab').siblings().removeClass('activeTab');
	});
});