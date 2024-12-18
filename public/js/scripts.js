//validacion del RUT
function checkRut(rut) {
  var valor = rut.value.replace('.','');
  valor = valor.replaceAll('-','');
  cuerpo = valor.slice(0,-1);
  dv = valor.slice(-1).toUpperCase();
  rut.value = cuerpo + '-'+ dv
  if(cuerpo.length < 7) { return false; }
  suma = 0;
  multiplo = 2;
  for(i=1;i<=cuerpo.length;i++) {
      index = multiplo * valor.charAt(cuerpo.length - i);
      suma = suma + index;
      if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  }
  dvEsperado = 11 - (suma % 11);
  dv = (dv == 'K')?10:dv;
  dv = (dv == 0)?11:dv;
  if(dvEsperado != dv) {  return false; }
  rut.setCustomValidity('');
}

//activacion de los tooltips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


 //cambia icono izq boton por icono carga y bloquea boton, NO AJAX
 $('body').on('click', '.submit_something', function (event) {
  event.preventDefault();
  $(this).addClass('disabled')
  $(this).html(`
    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
    <span class="" role="status">Cargando...</span>
  `).prop('disabled', true);

  setTimeout(() => {
    $(this).closest('form').submit();
  }, 2000);
  
});
/* 
* COMMENT SCRIPTS
*/
function updateComment(id) {
  $("#updateCommentModal").modal("show");
  
  let updateCommentID = $("#commentID-" + id).val();
  let updateCommentator = $("#commentator-" + id).text();
  let updateComment = $("#comment-" + id).text();

  $("#updateCommentID").val(updateCommentID);
  $("#updateCommentator").val(updateCommentator);
  $("#updateComment").val(updateComment);
}

function replyComment(id) {
  $("#replyCommentModal").modal("show");

  let getCommentID = $("#commentID-" + id).val();
  let getCommentator = $("#commentator-" + id).text();

  $("#replyCommentID").val(getCommentID);
  $("#replyTo").text(getCommentator);
}

function updateReply(id) {
  $("#updateReplyModal").modal("show");
  
  let updateReplyID = $("#replyID-" + id).val();
  let updateReplier = $("#replier-" + id).text();
  let updateReply = $("#reply-" + id).text();

  $("#updateReplyID").val(updateReplyID);
  $("#updateReplier").val(updateReplier);
  $("#updateReply").val(updateReply);
}
