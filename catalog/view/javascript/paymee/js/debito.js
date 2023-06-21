$('#bandeiras').on('change', '#input-bandeira', function() {
  $('#bandeiraEscolhida').html('');
  if(this.value == 'visa'){
    $('#bandeiraEscolhida').html('VISA ELECTRON');
  }else if(this.value == 'mastercard'){
    $('#bandeiraEscolhida').html('MAESTRO');
  }
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