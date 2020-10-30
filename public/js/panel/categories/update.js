function update(e)
{
    e.preventDefault();
    var name = document.getElementsByName('name').value();
    var token = document.getElementsByName('token').value();

    $.ajax({
        type: "POST",
        url: "/admin/product/categories/" + "/edit",
        data: {token: token, name: name},
        success: function(data) {
            var response = $.parseJSON(data);
        },
        error: function() {}
    })
}