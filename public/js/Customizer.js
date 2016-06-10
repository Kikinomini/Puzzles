var customizer = {
	brakeOptionsFront: [],
	brakeOptionsRear: [],
	currentBrakeFrontItemIndex: 0,
	currentBrakeRearItemIndex: 0,
	currentBrakeFrontPrice: 0,
	currentBrakeRearPrice: 0,
	bicyclePrice: 0,

	addManyBrakesFront: function(brakes)
	{
		brakes.forEach(function(brake){
			customizer.addBrakeFront(brake);
		})
	},

	addBrakeFront: function(brake)
	{
		this.brakeOptionsFront[brake.id] = {
			name: brake.name,
			price: brake.price,
		}
	},
	addManyBrakesRear: function(brakes)
	{
		brakes.forEach(function(brake){
			customizer.addBrakeRear(brake);
		})
	},

	addBrakeRear: function(brake)
	{
		this.brakeOptionsRear[brake.id] = {
			name: brake.name,
			price: brake.price,
		}
	},
	addBrakeOptionsToSelectBox: function()
	{
		var brakeSelectFront = $("#selectBrakeFront");
		for (key in this.brakeOptionsFront)
		{
			var item = this.brakeOptionsFront[key];
			brakeSelectFront.append($("<option>", {
				value: key,
				text: item.name+' '+helper.formatPrice(item.price - customizer.currentBrakeFrontPrice, true, true)
			}));
		}
		var brakeSelectRear = $("#selectBrakeRear");
		for (key in this.brakeOptionsRear)
		{
			var item = this.brakeOptionsRear[key];
			brakeSelectRear.append($("<option>", {
				value: key,
				text: item.name+' '+helper.formatPrice(item.price - customizer.currentBrakeRearPrice, true, true)
			}));
		}

	},
	init: function()
	{
		var brakeSelectFront = $("#selectBrakeFront");
		brakeSelectFront.change(function(){
			// $("#brakePrice").html(helper.formatPrice(customizer.brakeOptions[this.value].price));
			customizer.currentBrakeFrontItemIndex = this.value;
			customizer.setTotalPrice();
		});
		brakeSelectFront.val(this.currentBrakeFrontItemIndex);


		var brakeSelectRear = $("#selectBrakeRear");
		brakeSelectRear.change(function(){
			// $("#brakePrice").html(helper.formatPrice(customizer.brakeOptions[this.value].price));
			customizer.currentBrakeRearItemIndex = this.value;
			customizer.setTotalPrice();
		});
		brakeSelectRear.val(this.currentBrakeRearItemIndex);


		customizer.setTotalPrice();
	},

	setCurrentFrontBrake: function(index)
	{
		customizer.currentBrakeFrontItemIndex = index;
	},
	setCurrentRearBrake: function(index)
	{
		customizer.currentBrakeRearItemIndex = index;
	},

	setTotalPrice: function()
	{
		$("#totalPrice").html(helper.formatPrice(
			customizer.bicyclePrice
			+ customizer.brakeOptionsFront[this.currentBrakeFrontItemIndex].price
				- customizer.currentBrakeFrontPrice
			+ customizer.brakeOptionsRear[this.currentBrakeRearItemIndex].price
				- customizer.currentBrakeRearPrice
		), false);
	}

};
