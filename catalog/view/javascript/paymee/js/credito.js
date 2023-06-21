$('#bandeiras').on('change', '#input-bandeira', function() {
  parcelas($(this).val());
});

$('#input-cartao').on('keyup change', function() {
  $(this).val($(this).val().replace(/[^\d]/,''));
});

$('#input-codigo').on('keyup change', function() {
  $(this).val($(this).val().replace(/[^\d]/,''));
});

$('#payment input[type=\'text\'], #payment select').blur(function() {
  $('.text-danger').remove();
  $(this).removeClass('alert-danger');
});

$('#button-confirm').on('click', function() {
  validar($(this));
});