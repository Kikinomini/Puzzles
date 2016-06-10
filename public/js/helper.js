var helper = {
	formatPrice: function(price, withStar, withPlus)
	{
		if (typeof withStar == "undefined")
		{
			withStar = true;
		}
		price = parseFloat(price).toFixed(2);
		if (typeof withPlus == "undefined" || price < 0)
		{
			withPlus = false;
		}

		var parts = price.split('.');
		var digits = parts[0];
		var decimals = parts.length > 1 ? ',' + parts[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(digits)) {
			digits = digits.replace(rgx, '$1' + '.' + '$2');
		}
		price = digits + decimals+ ' €';

		if (withStar == true)
		{
			price += " *";
		}
		if (withPlus == true)
		{
			price = "+"+price;
		}
		return price;
	}
};