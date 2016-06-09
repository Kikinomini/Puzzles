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
	},
	hasForm: function()
	{
		return (this.form != null);
	},
	setSearch: function (search)
	{
		$(this.form).find("#search").val(search);
	}
};