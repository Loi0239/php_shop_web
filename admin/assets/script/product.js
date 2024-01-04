
// productAjax.js
function loadProductTable() {
    // var idPr = <?php echo $idPr; ?>;
    // var idSub = <?php echo $idSub; ?>;
    // var currentPage = <?php echo $currentPage; ?>;
    
    // Use AJAX to load the product table
    $.ajax({
        url: 'product.php',
        type: 'GET',
        data: {
            idPr: idPr,
            idSub: idSub,
            page: currentPage
        },
        success: function(response) {
            // Update the content of the product table container
            $('#productTableContainer').html(response);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
$('.delete').click(function(){
    var idpro = $(this).data('idpro'); console.log(idpro);
})