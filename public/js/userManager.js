/**
 * Created by Silas on 20.09.2015.
 */

var userManager =
{
    changeRoleResourceUrl: null,
    changeUserRoleUrl: null,
    changeRoleParentUrl: null,

    init: function (changeRoleResourceUrl, changeUserRoleUrl, changeRoleParentUrl) {
        this.changeRoleResourceUrl = changeRoleResourceUrl;
        this.changeUserRoleUrl = changeUserRoleUrl;
        this.changeRoleParentUrl = changeRoleParentUrl;
    },
    changeRoleResource: function (row, col, nTd) {
        var id = $(nTd).prop("id").split("_");
        var resourceId = id[id.length - 3];
        var roleId = $("#roleId__" + row).text();

        var imgSrc = $(nTd).children().first().prop("src").split("/");

        if (imgSrc[imgSrc.length - 1] == "hacken.png") {
            var isAllowed = 0;
        }
        else {
            var isAllowed = 1;
        }

        $.ajax(this.changeRoleResourceUrl, {
            method: "POST",
            data: {
                roleId: roleId,
                resourceId: resourceId,
                isAllowed: isAllowed
            }
        }).done(function (data, textStatus, jqXHR) {
            var object = JSON.parse(data);
            var resource;
            var roles = object.roles;
            $.each(roles, function (index, value) {
                resource = $("#resource_" + object.resourceId + "__" + userManager.findRowById(index)).children().first();
                if (value == 0) {
                    $(resource).prop("src", settings.basePath + "/images/kreuz.png");
                }
                else if (value == 1) {
                    $(resource).prop("src", settings.basePath + "/images/hacken.png");
                } else if (value == 2) {
                    $(resource).prop("src", settings.basePath + "/images/hacken_grau.png");
                }
            });

        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        });

    },
    findRowById: function (id) {
        var n = 0;

        while ($("#roleId__" + n)) {
            if ($("#roleId__" + n).text() == id) {
                return n;
            }
            n++;
        }
        return -1;
    },
    addRole: function(rowNumber)
    {
        var roleId = $("#roleId__" + rowNumber).text();

        $.ajax(this.changeUserRoleUrl, {
            method: "POST",
            data: {
                roleId: roleId,
                addRole: 1
            }
        }).done(function (data, textStatus, jqXHR) {
            console.log(data);
            var object = JSON.parse(data);
            if (object.hasRole == true) {
                var userRoleList = $("#userRoleList").DataTable();
                var roleList = $("#roleList").DataTable();
                var row = roleList.row($("#roleList_" + rowNumber));
                var rowNode = row.node();
                userRoleList.row.add(rowNode);
                var index = userRoleList.row(rowNode).index();

                $("#roleList_"+rowNumber).prop("id", "userRoleList_"+index);
                $("#roleId__"+rowNumber).prop("id", "userRoleId__"+index);

                var imgCell = $("#plus__"+rowNumber);
                imgCell.prop("id", "minus__"+index);
                var img = $("<img class = 'datatableImg button' src = '"+settings.basePath+"/images/minus.png'>");
                imgCell.off("click");
                $(img).click(function () {
                    userManager.removeRole(index);
                });
                imgCell.html(img);

                row.remove();
                roleList.draw();
                userRoleList.draw();
            }
            console.log(object);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        });
    },
    removeRole: function(rowNumber)
    {
        var roleId = $("#userRoleId__" + rowNumber).text();

        $.ajax(this.changeUserRoleUrl, {
            method: "POST",
            data: {
                roleId: roleId,
                addRole: 0
            }
        }).done(function (data, textStatus, jqXHR) {
            console.log(data);
            var object = JSON.parse(data);
            if (object.hasRole == false) {
                var userRoleList = $("#userRoleList").DataTable();
                var roleList = $("#roleList").DataTable();
                var row = userRoleList.row($("#userRoleList_" + rowNumber));
                var rowNode = row.node();
                roleList.row.add(rowNode);
                var index = roleList.row(rowNode).index();

                $("#userRoleList_"+rowNumber).prop("id", "roleList_"+index);
                $("#userRoleId__"+rowNumber).prop("id", "roleId__"+index);

                var imgCell = $("#minus__"+rowNumber);
                imgCell.prop("id", "plus__"+index);
                var img = $("<img class = 'datatableImg button' src = '"+settings.basePath+"/images/plus.png'>");
                imgCell.off("click");
                $(img).click(function () {
                    userManager.addRole(index);
                });
                imgCell.html(img);

                row.remove();
                userRoleList.draw();
                roleList.draw();
            }
            console.log(object);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        });
    },
    addParent: function(rowNumber)
    {
        var parentId = $("#roleId__" + rowNumber).text();

        $.ajax(this.changeRoleParentUrl, {
            method: "POST",
            data: {
                parentId: parentId,
                addParent: 1
            }
        }).done(function (data, textStatus, jqXHR) {
            console.log(data);
            var object = JSON.parse(data);
            if (object.hasParent == true) {
                var parentList = $("#parentList").DataTable();
                var roleList = $("#roleList").DataTable();
                var row = roleList.row($("#roleList_" + rowNumber));
                var rowNode = row.node();
                parentList.row.add(rowNode);
                var index = parentList.row(rowNode).index();

                $("#roleList_"+rowNumber).prop("id", "parentList_"+index);
                $("#roleId__"+rowNumber).prop("id", "parentId__"+index);

                var imgCell = $("#plus__"+rowNumber);
                imgCell.prop("id", "minus__"+index);
                var img = $("<img class = 'datatableImg button' src = '"+settings.basePath+"/images/minus.png'>");
                imgCell.off("click");
                $(img).click(function () {
                    userManager.removeParent(index);
                });
                imgCell.html(img);

                row.remove();
                roleList.draw();
                parentList.draw();
            }
            console.log(object);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        });
    },
    removeParent: function(rowNumber)
    {
        var parentId = $("#parentId__" + rowNumber).text();

        $.ajax(this.changeRoleParentUrl, {
            method: "POST",
            data: {
                parentId: parentId,
                addParent: 0
            }
        }).done(function (data, textStatus, jqXHR) {
            console.log(data);
            var object = JSON.parse(data);
            if (object.hasParent == false) {
                var parentList = $("#parentList").DataTable();
                var roleList = $("#roleList").DataTable();
                var row = parentList.row($("#parentList_" + rowNumber));
                var rowNode = row.node();
                roleList.row.add(rowNode);
                var index = roleList.row(rowNode).index();

                $("#parentList_"+rowNumber).prop("id", "roleList_"+index);
                $("#parentId__"+rowNumber).prop("id", "roleId__"+index);

                var imgCell = $("#minus__"+rowNumber);
                imgCell.prop("id", "plus__"+index);
                var img = $("<img class = 'datatableImg button' src = '"+settings.basePath+"/images/plus.png'>");
                imgCell.off("click");
                $(img).click(function () {
                    userManager.addParent(index);
                });
                imgCell.html(img);

                row.remove();
                parentList.draw();
                roleList.draw();
            }
            console.log(object);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        });
    }
}