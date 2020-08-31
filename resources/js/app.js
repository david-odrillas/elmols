require('./bootstrap');

$(document).ready(function(){
  $('.toast').toast('show');
  //Eliminar un elemento de la lista
  $('.delete-row').click(function(event){
   event.preventDefault();
    $('.delete-form').attr('action', $(this).attr('href'));
    $('.delete-modal').modal('show');
  });
  //buscar producto
  $("#search-product").keyup(function(){
    let name = $("#search-product").val();
    name=='' ? $("#list-product").empty():
    $.get("/search", { name: name }, function (datos) {
      $("#list-product").html(datos);
    });
  });
  //agregar item a la tabla
  $("#list-product").on("click","a",function(){
    $("#det-pro").prepend(`<tr><td><button type="button" class="close"><span>&times;</span></button></td> <td>${$(this).attr("data-name")} <sub>${$(this).attr("data-volumen")}</sub> <input type="hidden" name="unit_id[]" value="${$(this).attr('data-unit')}"></td> <td data-price=${$(this).attr('data-price')}><input type='number' name='quantity[]' class='form-control input-quantity' min='1' value='1'></td> <td class='subtotal'><input type='text' readonly class='form-control-plaintext text-right input-price' name='total[]' value=${$(this).attr('data-price')}></td> </tr>`);
    $("#search-product").val('');
    $("#list-product").empty();
    $("#total").text(parseFloat($("#total").text())+parseFloat($(this).attr('data-price')));
    $("#amount").val(parseFloat($("#total").text()));
    $("#payment").val('');
    $("#change").val('');
    $("#search-product").focus();
  });

  //Eliminar fila de la tabla detalles --volver a sumar al eliminar.
  $( "#sales-detail tbody" ).on( "click", ".close", function() {
    let fila = $(this).parent().siblings("td.subtotal").children(".input-price").val();
    $("#total").text(parseFloat($("#total").text()) - parseFloat(fila));
    $("#amount").val(parseFloat($("#total").text()));
    $(this).parent().parent().remove();
  });
  //validar precio - cantidad en tabla
  $("#sales-detail tbody").on('input', ".input-quantity", function () {
      var quantity = this.value;
      var price =$(this).parent().attr("data-price");
      $(this).parent().siblings("td.subtotal").children(".input-price").val(quantity*price);
      let total = 0.0;
      $(".input-price").each(function(i, punto) {
          total += parseFloat($(punto).val());
      });
      $("#total").text(total);
      $("#amount").val(total);
      $("#payment").val('');
      $("#change").val('');
  });
  //calculadora
  $("#payment, #amount").on('input',function () {
      let payment = parseFloat($("#payment").val());
      let amount = parseFloat($("#amount").val());
      $("#change").val(payment-amount);
  });
});
