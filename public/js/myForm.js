/**
 * Created by Silas on 30.03.2015.
 */
var myForm =
{
    myMultiCheckbox_checkAll: function (name) {
        $("[name^=\"" + name + "\"]").prop('checked', $("[name=\"" + name + "__all\"]").prop('checked'));
    }
}