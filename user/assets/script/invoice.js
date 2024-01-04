$('.btn-change').on('click', function() {
    var idInvoice = $(this).data('id');
    $.ajax({
        url: 'index.php?route=invoice',
        method: "GET",
        data: {idInvoice: idInvoice},
        success: function(data) {
            var tableHtml = $(data).find('.table').html();
            console.log(tableHtml);
            $('.table').html(tableHtml);
        },
        error: function() {
            console.log("Error fetching wards");
        }
    });
})