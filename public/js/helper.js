var helper = {
	formatPrice: function(price, withStar)
	{
		if (typeof withStar == "undefined")
		{
			withStar = true;
		}

		var parts = parseFloat(price).toFixed(2).split('.');
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
		return price;
	}
};