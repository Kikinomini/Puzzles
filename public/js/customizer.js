var customizer = {
	options: {},
	currentIndexes: {},
	currentPrices: {},
	bicyclePrice: 0,

	init: function ()
	{
		this.checkCurrentIndexes();
		this.setCurrentPrices();
		this.setOptionsToSelect();
		this.setOnChangeListener();
		this.setTotalPrice();
	},
	addManyOptions: function (selectId, options)
	{
		options.forEach(function (option)
		{
			customizer.addOption(selectId, option);
		});
	},
	addOption: function (selectId, option)
	{
		if (typeof this.options[selectId] == "undefined")
		{
			this.options[selectId] = {};
		}
		this.options[selectId][option.id] = option;
	},

	setCurrentId: function (selectId, itemId)
	{
		this.currentIndexes[selectId] = itemId;
	},

	setOptionsToSelect: function ()
	{
		var item;
		var select;
		for (var selectId in this.options)
		{
			select = $("#" + selectId);
			for (var itemId in this.options[selectId])
			{
				item = this.options[selectId][itemId];
				select.append($("<option>", {
					value: itemId,
					text: item.name + ' ' + helper.formatPrice(item.price - this.currentPrices[selectId], true, true)
				}));
			}
			select.val(this.currentIndexes[selectId]);
		}
	},

	checkCurrentIndexes: function ()
	{
		for (var selectId in this.options)
		{
			if (typeof this.currentIndexes[selectId] == "undefined")
			{
				this.currentIndexes[selectId] = Object.keys(this.options[selectId])[0];
			}
		}
	},

	setCurrentPrices: function ()
	{
		for (var selectId in this.options)
		{
			if (typeof this.currentPrices[selectId] == "undefined")
			{
				this.currentPrices[selectId] = this.options[selectId][this.currentIndexes[selectId]].price;
			}
		}
	},

	setOnChangeListener: function ()
	{
		$(".customizingSelectBox").change(function ()
		{
			customizer.currentIndexes[$(this).attr("id")] = this.value;
			customizer.setTotalPrice();
		});
	},
	setTotalPrice: function ()
	{
		var totalPrice = this.bicyclePrice;
		$.each(this.currentPrices, function (selectId, price)
		{
			totalPrice += customizer.options[selectId][customizer.currentIndexes[selectId]].price - price;
		});
		$("#totalPrice").html(helper.formatPrice(totalPrice));
	},

	setBicyclePrice: function (bicyclePrice)
	{
		this.bicyclePrice = bicyclePrice;
	},

	getSelectValues: function()
	{
		return $.extend({}, this.currentIndexes);
	}
};
