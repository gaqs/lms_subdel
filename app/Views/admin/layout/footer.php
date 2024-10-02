
</body>
</html>
<script type="text/javascript" src="<?= base_url('dist/bootstrap-5.3.3/js/bootstrap.bundle.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('dist/datatables-2.1.3/datatables.js');?>"></script>

<script type="text/javascript" src="<?= base_url('dist/trumbowyg-2.28.0/trumbowyg.js');?>"></script>
<script type="text/javascript" src="<?= base_url('dist/trumbowyg-2.28.0/plugins/base64/trumbowyg.base64.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('dist/trumbowyg-2.28.0/plugins/fontsize/trumbowyg.fontsize.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('dist/trumbowyg-2.28.0/plugins/pasteimage/trumbowyg.pasteimage.js'); ?>"></script>

<script type="text/javascript" src="<?= base_url('js/jquery-resizable.min.js?v=0.1'); ?>"></script>

<script type="text/javascript" src="<?= base_url('dist/trumbowyg-2.28.0/plugins/resizimg/trumbowyg.resizimg.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('dist/trumbowyg-2.28.0/langs/es.js');?>"></script>

<!--<script type="text/javascript" src="<?= base_url('js/jquery-sortable.js'); ?>"></script>-->

<script type="text/javascript" src="<?= base_url('js/video.min.js'); ?>"></script>

<script type="text/javascript" src="<?= base_url('js/scripts.js'); ?>"></script>

<!-- scripts -->
<script>
  $(document).ready(function() {

    $('a[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('a[href="' + activeTab + '"]').tab('show');
    }

    var user_table = new DataTable('#users_table',{
      language: {
        url: 'https://cdn.datatables.net/plug-ins/2.1.3/i18n/es-MX.json',
      }
    });

    $('#textarea-description, #textarea-lesson').trumbowyg({
      lang: 'es',
      btnsDef: {
        image: {
          dropdown: ['insertImage', 'base64'],
          ico: 'insertImage'
        }
      },
      btns: [
        ['viewHTML'],
        ['formatting'],
        ['strong', 'em', 'del'],
        ['fontsize'],
        ['superscript', 'subscript'],
        ['link'],
        ['image'],
        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
        ['unorderedList', 'orderedList'],
        ['horizontalRule'],
        ['removeformat'],
        ['fullscreen']
      ]
    });

  });

  
</script>
