/**
 * Created by Marten on 12.06.2016.
 */

var pageNavigator = {
	maxPage: 0,
	actualPage: 0,
	createdDiv: null,
	maxSeitenNebeneinander: 5,


	createButtons:function(){
		if (pageNavigator.createdDiv != null){
			return pageNavigator.createdDiv;
		}
		var out = "";

		if(pageNavigator.maxPage <= 5){
			for(i = 1; i <= pageNavigator.maxPage; i++){
				out = out + pageNavigator.createOneButton(i);
			}
		}else{
			if (pageNavigator.actualPage <= this.maxSeitenNebeneinander){
				for(i = 1; i<= this.maxSeitenNebeneinander+1; i++){
					out = out + pageNavigator.createOneButton(i);
				}
				out = out + pageNavigator.createPointDiv() + pageNavigator.createOneButton(pageNavigator.maxPage);
			}else{
				if(pageNavigator.actualPage+this.maxSeitenNebeneinander >=pageNavigator.maxPage){
					out = pageNavigator.createOneButton(1) + pageNavigator.createPointDiv();
					for (i = pageNavigator.maxPage - this.maxSeitenNebeneinander; i<= pageNavigator.maxPage; i++){
						out = out + pageNavigator.createOneButton(i)
					}
				}
				else{
					out = pageNavigator.createOneButton(1)+pageNavigator.createPointDiv();
					for(i = pageNavigator.actualPage-2; i <= pageNavigator.actualPage+2; i++){
						out = out + pageNavigator.createOneButton(i);
					}
					out = out + pageNavigator.createPointDiv() + pageNavigator.createOneButton(pageNavigator.maxPage);
				}
			}
		}
		pageNavigator.createdDiv = '<ul class="pagination" role="navigation" aria-label="Pagination">Seite &nbsp;&nbsp;' + out + "</ul>";
		return pageNavigator.createdDiv;
	},

	addOnClickListener: function()
	{
		$(".pageNavigatorButton").click(function(){
			pageNavigator.buttonPressed($(this).attr("data-page"));
		});
	},

	createOneButton:function(num){
		if(num == pageNavigator.actualPage){
			return '<li class="current"><span class="show-for-sr">Momentan auf:</span>' + num + '</li>';
		}
		return "<li><button type='pageNavigatorButton' onclick='pageNavigator.buttonPressed("+num+")'>"+ num +"</button></li>";
	},
	createPointDiv:function (){
		return '<li class="ellipsis" aria-hidden="true"></li>'
	},

	buttonPressed:function(num){
		FilterForm.setSide(num);
		FilterForm.sendForm();
	}
};