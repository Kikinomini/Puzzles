var FilterForm = {

	form: null,

	setForm: function(form)
	{
		this.form = form;
	},
	sendForm: function()
	{
		$(this.form).submit();
	},
	setSide: function (sideNumber)
	{
		$(this.form).find("#page").val(sideNumber);
	}
};