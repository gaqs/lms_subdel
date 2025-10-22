<!-- Footer -->
<footer class="page-footer font-small mdb-color pt-5 mt-5 text-white" style="background-color:#08261c;">
  <div class="container text-start">
    <div class="row text-start mt-3 pb-3">
      <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
        <h6 class="text-uppercase mb-4 font-weight-bold">LMS</h6>
        <p>
        <address>
          <strong>Subdirección de Desarrollo Económico Local<br>Dirección de Desarrollo Comunitario</strong>
          <br>
          <a href="https://www.puertomontt.cl/unidades-municipales/dideco/" target="_blank">Más información</a>
        </address>
        </p>
      </div>
      <div class="col-md-5 col-lg-4 col-xl-4 mx-auto mt-4">
        <h6 class="text-uppercase mb-4 font-weight-bold">CONTACTO</h6>
        <p><i class="fa fa-home mr-3"></i> Av. Presidente Ibañez #600.<br>Edificio Consistorial II<br></p>
        <p><i class="fa fa-envelope mr-3"></i> contacto@subdelpuertomontt.cl<br><i class="fa fa-envelope mr-3"></i> universidadabierta@gmail.com</p>
        <p><i class="fa fa-phone mr-3"></i> (+65) 2 261315<br><i class="fa fa-phone mr-3"></i> (+65) 2 261306</p>
        <p></p>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
        <h6 class="text-uppercase mb-4 font-weight-bold">Links Útiles</h6>
        <p><a href="https://www.puertomontt.cl/" target="_blank">Municipalidad Puerto Montt</a></p>
        <p><a href="http://www.ulagos.cl/" target="_blank">Universidad de los Lagos</a></p>
        <p><a href="http://www.ulagos.cl/category/campus-pto-montt/" target="_blank">ULL Campus Puerto Montt</a></p>
        <p><a href="<?= base_url('admin/login'); ?>" target="_blank" class="">Acceso Administrador</a></p>
      </div>

    </div>
    <!-- Footer links -->

    <hr>

    <!-- Grid row -->
    <div class="row d-flex align-items-center pb-2">

      <!-- Grid column -->
      <div class="col-md-12 col-lg-12">

        <!--Copyright-->
        <small class="text-center text-md-left"><b> Gustavo Quilodrán Sanhueza</b> | SUBDEL | Municipalidad de Puerto Montt | contact: gaqs.02@gmail.com</small>

      </div>
      <!-- Grid column -->
    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

</footer>
<!-- Footer -->

</body>
</html>
<script src="https://unpkg.com/@popperjs/core@^2.0.0"></script>
<script type="text/javascript" src="<?= base_url('dist/bootstrap-5.3.3/js/bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('js/jquery-3.7.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('js/video.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('js/scripts.js'); ?>"></script>
<script>  

  let lessonID = window.location.href.split('/').pop(); //id de la leccion desde url
  let courseID = '<?= isset($course->id) ? $course->id : ''; ?>'; //id del curso desde php
  //verificar progreso solo si se esta en url de lesson

  //progress lessons
  $(document).ready(function() {

    if( window.location.pathname.includes('/lesson') ){
      checkLiveProgress(courseID);
      //video % de termino
      const video = document.getElementById('lesson_video');
      if( video ){
        let watchedPercentage = 0;
        video.addEventListener('timeupdate', () => {
            const percentage = Math.floor((video.currentTime / video.duration) * 100);
            watchedPercentage = Math.max(watchedPercentage, percentage);
        });

        //actualizacion % en base de datos cuando este termina, si el video se completa o se hace click en el check
        video.addEventListener('ended', () => { sendLessonProgress( lessonID, watchedPercentage, courseID); });
        video.addEventListener('pause', () => { sendLessonProgress( lessonID, watchedPercentage, courseID); });
        video.addEventListener('beforeunload', () => { sendLessonProgress( lessonID, watchedPercentage, courseID); });
      }

      const checkboxes = document.querySelectorAll('.check_lesson');
      checkboxes.forEach(check => {
        check.addEventListener('change', () => {
          const lesson_id = check.value;
          let progress = (check.checked) ? '100' : '0';
          sendLessonProgress(lesson_id, progress, courseID);
        });
      })
    }
  });

  function sendLessonProgress(id,progress,course_id = courseID){
    $.ajax({
      type: 'POST',
      url: "<?= base_url('lesson/progress') ?>",
      data: 'lesson_id='+id+'&progress='+progress+'&course_id='+course_id,
      success: function(data){
        checkLiveProgress(course_id);
      }
    });
  }

  function checkLiveProgress(id){
    $.ajax({
      type: 'POST',
      url: "<?= base_url('lesson/check_live_progress') ?>",
      data: 'course_id='+id,
      success: function(data){
        //actualizacion visual de barra progress
        progressContainer = document.querySelector('#progress_bar .progress');
        progressBar = progressContainer.querySelector('#progress_bar .progress-bar');
        progressBar.style.width = data+'%';
        progressBar.textContent = data+'%';
        progressContainer.setAttribute('aria-valuenow', data);
      }
    })
  }
  
</script>
<script type="module">
  //pdf % de termino
  const pdfjs = await import('<?= base_url('dist/pdfjs-4.9.124/build/pdf.mjs'); ?>');
  pdfjs.GlobalWorkerOptions.workerSrc = '<?= base_url('dist/pdfjs-4.9.124/build/pdf.worker.mjs'); ?>';

  const canvas = document.getElementById('pdf_canvas');
    if( canvas ){
      let pdfDoc        = null;
      let currentPage   = 1;
      let zoomLevel     = 1;
      const pdfCanvas   = document.getElementById('pdf_canvas');
      const ctx         = pdfCanvas.getContext('2d');

      const totalPagesElement  = document.getElementById('total_pages');
      const currentPageElement = document.getElementById('current_page');

      const contentFile = '<?= isset($content->file) ? base_url('public/uploads/lessons/'.$content->file) : ''; ?>'
      //carga de pdf
      pdfjsLib.getDocument(contentFile).promise.then( (pdf) => {
        pdfDoc = pdf;
        totalPagesElement.textContent = pdfDoc.numPages;
        renderPage(currentPage);
      });

      function renderPage(pageNum){
        pdfDoc.getPage(pageNum).then( (page) => {
          const viewport = page.getViewport({scale: zoomLevel});
          pdfCanvas.height = viewport.height;
          pdfCanvas.width = viewport.width;

          const renderContext = {
            canvasContext: ctx,
            viewport:viewport
          };
          page.render(renderContext);
          currentPageElement.textContent = pageNum;
        })
      }

      // Navegar a la siguiente página
      document.getElementById('next_page').addEventListener('click', () => {
        if (currentPage >= pdfDoc.numPages) return;
        currentPage++;
        renderPage(currentPage);
        let porcentage = (currentPage * 100) / pdfDoc.numPages;

        sendLessonProgress(lessonID, porcentage);
      });

      document.getElementById('prev_page').addEventListener('click', () => {
        if (currentPage <= 1) return;
        currentPage--;
        renderPage(currentPage);
      });

      document.getElementById('zoomin').addEventListener('click', () => {
        zoomLevel += 0.1
        renderPage(currentPage)
      });

      document.getElementById('zoomout').addEventListener('click', () => {
        if( zoomLevel > 1 ){
          zoomLevel -= 0.1;
          renderPage(currentPage);
        }
      });

    }
</script>
