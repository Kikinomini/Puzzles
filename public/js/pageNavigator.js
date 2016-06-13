/**
 * Created by Marten on 12.06.2016.
 */

var pageNavigator = {
	maxPage: 0,
	actualPage: 0,
	createdDiv: "0",


	createButtons:function(){
		if (pageNavigator.createdDiv != '0'){
			return pageNavigator.createdDiv;
		}
		var out = "";

		if(pageNavigator.maxPage <= 5){
			for(i = 1; i <= pageNavigator.maxPage; i++){
				out = out + pageNavigator.createOneButton(i);
			}
		}else{
			if (pageNavigator.actualPage <= 3){
				for(i = 1; i<=4; i++){
					out = out + pageNavigator.createOneButton(i);
				}
				out = out + pageNavigator.createPointDiv() + pageNavigator.createOneButton(pageNavigator.maxPage);
			}else{
				if(pageNavigator.actualPage+3 >=pageNavigator.maxPage){
					out = pageNavigator.createOneButton(1) + pageNavigator.createPointDiv();
					for (i = pageNavigator.maxPage - 3; i<= pageNavigator.maxPage; i++){
						out = out + pageNavigator.createOneButton(i)
					}
				}
				else{
					out = pageNavigator.createOneButton(1)+pageNavigator.createPointDiv();
					for(i = pageNavigator.actualPage-1; i <= pageNavigator.actualPage+1; i++){
						out = out + pageNavigator.createOneButton(i);
					}
					out = out + pageNavigator.createPointDiv() + pageNavigator.createOneButton(pageNavigator.maxPage);
				}
			}
		}
		pageNavigator.createdDiv = "<div class='completePageNavigator row'>Seitennavigation:" + out + "</div>";
		return pageNavigator.createdDiv;
	},

	createOneButton:function(num){
		if(num == pageNavigator.actualPage){
			return " <" + num + "> ";
		}
		return "<button type='pageNavigatorButton' onclick='pageNavigator.buttonPressed("+num+")'> <"+ num +"> </button>";
	},
	createPointDiv:function (){
		return "..."
	},

	buttonPressed:function(num){
		FilterForm.setSide(num);
		FilterForm.sendForm();
	}

}