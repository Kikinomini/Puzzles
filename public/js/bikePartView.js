var elementRender = {	AllElements: [] ,	BikeList: false,	addOneElement:function (element)	{		element["price"] = helper.formatPrice(element["price"]);		this.AllElements.push(element);	},	addArrayElements:function (arrayElement){		arrayElement.forEach(function (entry){			elementRender.addOneElement(entry);		})	},	createList:function ()	{		var top = pageNavigator.createButtons() + "<div class = 'table maxWidth'>";		var header = "<div class ='table_row'> " +			"<div class = 'cell'></div> " +			"<div class = 'cell'><b><u>Name</b></u></div>";		if(elementRender.BikeList)		{			header = header + "<div class = 'cell'><b><u>Fahrradtype<br>Radgröße<br>Ramengröße</u></b></div> ";		}		header = header +"<div class = 'cell'><b><u>Preis</b></u></div> </div>";		var main = "";		console.log(this.AllElements);		this.AllElements.forEach(function(element){			main = main+ "<a class = \"table_row totalyHidden hiddenLink\"  href=\"" + element["url"] +"\" >";				main =main + "<div class = \"cell bikePartImg\"><img class = \"bikePartImg\" src=\"/image/"+ element["pictureName"] + "\">" +					"</div>";				main = main + 	"<div class = \"bikePartInfo cell\"> " +									"<div class = 'bikePartName'>" + element["name"] +										"</div> " +									"<div>" + element["quickDescription"] +										"</div>" +								"</div>";				if(elementRender.BikeList){					main = main + "<div class = \"cell\">" +						"<div class = \"table_row bikeType\">Fahrradtype: "+element["bikeType"] + "</div>" +						"<div class =\"table_row weelSize\">Radgröße: "+ element["weelSize"] + "\"</div>" +						"<div class =\"table_row frameSize\">Rahmengröße: "+ element["frameSize"] +"\"</div>" +						"</div>";			}			main = main + "<div class = 'cell bikePartPrice'>"+ element["price"] +"</div> " +				"</a>";		});		console.log(top);		returnVal=top + header + main + "</div>" + elementRender.Mehrwertsteuer;		$("#AusgabePanel").html(returnVal);	},	createBox:function(){		var top = pageNavigator.createButtons() + "<div class=\"row\">";		var elementNum = 0;		var mainrow = "";		for(i = 0;i<this.AllElements.length;i++){			mainrow = mainrow + this.createSingleBox(this.AllElements[i]);		}		end = "</div>";		document.getElementById("AusgabePanel").innerHTML = top + mainrow + end + elementRender.Mehrwertsteuer;	},	createSingleBox:function(element){		var top = "<div class = \"large-3 medium-4 small-12 columns\">";		var startLink = "<a class = \"table_row totalyHidden hiddenLink\"  href=\"" + element["url"] +"\" >";		var bild = 	"<div class = \"table_row PictureRow\">" +			"<img class = \"bikePartImg\" src=\"/image/"+ element["pictureName"] + "\">" +			"</div>";		var name = "<div class = \"bikePartName NameRow\" >" + element["name"] + "</div>";		var discr = "<div class = \"DetailRow table_row\" >" + element["quickDescription"] + "</div>";		var price = "<div class = \"PriceRow table_row\" >" + element["price"] + "</div>";		var endlink = "</a>";		var bottom = "</div>";		return top + startLink + bild + name + discr + price + endlink + bottom;	}}