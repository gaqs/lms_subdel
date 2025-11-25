<?= $this->extend('web/layout/app') ?>

<?= $this->section('title') ?>Terminos y Condiciones <?= $this->endSection() ?>

<?= $this->section('main') ?>

<?php if (session('error') !== null) : ?>
<div class="alert alert-dismissible fade show alert-danger alert_home">
  <?= session('error') ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif ?>

<section id="ttcc" class="sections">

  <div class="container">
    <div class="row">
        <div class="col-12 col-md-10">
            <h2>Términos y Condiciones de Uso</h2>
            <h3>Plataforma LMS de la Ilustre Municipalidad de Puerto Montt</h3>
            <p class="text-secondary">Fecha de última actualización: 23 de Octubre de 2025</p>

            <ol>
                <li>
                    <b>¿De qué se trata la Plataforma LMS de la Ilustre Municipalidad de Puerto Montt?</b>
                    <br>
                    La Plataforma LMS de la Ilustre Municipalidad de Puerto Montt (en adelante, la “Plataforma”) es un sitio web desarrollado y administrado por la Municipalidad, cuyo objetivo es ofrecer acceso gratuito a cursos, capacitaciones y material educativo en formato digital, dirigidos a la comunidad.
                    <br>
                    Los cursos disponibles en la Plataforma son creados y/o gestionados por la Ilustre Municipalidad de Puerto Montt, a través de sus distintas unidades y programas. Su propósito es contribuir al aprendizaje, la formación ciudadana y el fortalecimiento de competencias personales y laborales de los habitantes de la comuna.
                    <br>
                    Al finalizar un curso, y siempre que el usuario haya cumplido los requisitos académicos establecidos en cada uno, se entregará un certificado digital de finalización, emitido por la Ilustre Municipalidad de Puerto Montt.
                </li>
                <br>
                <li>
                    <b>¿Qué son los Términos y Condiciones?</b>
                    <br>
                    Los presentes Términos y Condiciones (en adelante, “T&C”) regulan el acceso y uso de la Plataforma, desde donde sea que el usuario se conecte.
                    <br>
                    El acceso, registro o uso de la Plataforma implica la aceptación plena y sin reservas de estos T&C. Si no estás de acuerdo con ellos, deberás abstenerte de utilizar el sitio.
                </li>
                <br>
                <li>
                    <b>Acceso y uso de la Plataforma</b>
                    <br>
                    El acceso a los cursos y contenidos de la Plataforma es gratuito, y se realiza únicamente mediante el registro previo de una cuenta de usuario.
                    <br>
                    Los usuarios podrán inscribirse en los cursos disponibles, acceder a los materiales educativos, realizar actividades evaluativas y, en caso de cumplir con los requisitos establecidos, descargar su certificado de finalización.
                    <br>
                    La Municipalidad podrá agregar, modificar o eliminar cursos, materiales o funcionalidades de la Plataforma en cualquier momento, sin previo aviso, en función de mejoras, actualización de contenidos o razones técnicas o administrativas.
                </li>
                <br>
                <li>
                    <b>Registro de usuarios</b>
                    <br>
                    Para acceder a los cursos, el usuario deberá registrarse proporcionando un correo electrónico válido y una contraseña segura, junto con los datos personales solicitados en el formulario de inscripción.
                    <br>
                    Cada cuenta de usuario es única, personal e intransferible. El usuario es responsable de mantener la confidencialidad de su clave secreta y de toda actividad realizada desde su cuenta.
                    <br>
                    Si la Municipalidad detecta información falsa, desactualizada, uso indebido o fraudulento de una cuenta, podrá suspender o eliminar el acceso del usuario a la Plataforma, informando de ello al correo registrado.
                </li>
                <br>
                <li>
                    <b>Propiedad intelectual</b>
                    <br>
                    Todos los cursos, materiales, textos, imágenes, videos, recursos didácticos y evaluaciones disponibles en la Plataforma son propiedad intelectual de la Ilustre Municipalidad de Puerto Montt, o de los autores que colaboren con ella, y están protegidos por la legislación chilena vigente.
                    <br>
                    El usuario podrá acceder y utilizar dichos contenidos exclusivamente con fines personales y educativos. Queda estrictamente prohibida su reproducción, copia, distribución, modificación o uso con fines comerciales, sin autorización expresa y por escrito de la Municipalidad.
                </li>
                <br>
                <li>
                    <b>Certificados de finalización</b>
                    <br>
                    Al completar satisfactoriamente un curso y cumplir con los requisitos de aprobación establecidos, el usuario podrá descargar un certificado digital de finalización emitido por la Ilustre Municipalidad de Puerto Montt.
                    <br>
                    Este certificado acredita la participación y cumplimiento del curso, pero no constituye un título profesional, técnico ni grado académico.
                </li>
                <br>
                <li>
                    <b>Descargo de responsabilidades</b>
                    <br>
                    La Ilustre Municipalidad de Puerto Montt pone a disposición la Plataforma y sus contenidos “tal como están”, sin garantizar su disponibilidad permanente o libre de errores.
                    <br>
                    La Municipalidad no se hace responsable por:
                    <ol>
                        <li>Interrupciones del servicio derivadas de fallas técnicas, mantenciones o fuerza mayor.</li>
                        <li>Daños o pérdidas derivadas del uso indebido de la Plataforma.</li>
                        <li>La interpretación, aplicación o resultados derivados del uso de los contenidos educativos publicados.</li>
                        <li>El uso de la Plataforma y de los materiales disponibles es de exclusiva responsabilidad del usuario.</li>
                    </ol>
                </li>
                <br>
                <li>
                    <b>Conducta de los usuarios</b>
                    <br>
                    Los usuarios deberán utilizar la Plataforma de manera respetuosa y conforme a la ley. Está prohibido publicar, compartir o difundir material que sea ilegal, difamatorio, ofensivo, discriminatorio, pornográfico o que infrinja derechos de propiedad intelectual de terceros.
                    <br>
                    La Municipalidad podrá suspender o eliminar la cuenta de cualquier usuario que incurra en estas conductas, sin perjuicio de las acciones legales que pudieran corresponder.
                </li>
                <br>
                <li>
                    <b>Privacidad y protección de datos personales</b>
                    <br>
                    Los datos personales recolectados a través del registro o uso de la Plataforma serán tratados conforme a la Ley N° 19.628 sobre Protección de la Vida Privada.
                    <br>
                    La Municipalidad utilizará la información únicamente para:
                    <ol>
                        <li>Gestionar el acceso a los cursos y recursos educativos.</li>
                        <li>Emitir certificados de finalización.</li>
                        <li>Realizar análisis estadísticos y de mejora del servicio.</li>
                    </ol>
                    Los datos no serán cedidos a terceros, salvo obligación legal.
                    <br>
                    Los usuarios podrán ejercer sus derechos de acceso, rectificación, cancelación u oposición a sus datos personales, contactando a la Municipalidad mediante los canales oficiales de atención.
                </li>
                <br>
                <li>
                   <b>Modificación de los Términos y Condiciones</b>
                    <br>
                    La Ilustre Municipalidad de Puerto Montt podrá modificar estos T&C en cualquier momento, publicando la versión actualizada en la Plataforma. El uso posterior del sitio implica la aceptación de las modificaciones realizadas.
                </li>
                <br>
                <li>
                    <b>Jurisdicción y ley aplicable</b>
                    <br>
                    Estos Términos y Condiciones se rigen por las leyes de la República de Chile. Cualquier controversia relacionada con la Plataforma será sometida a los tribunales ordinarios de justicia de la comuna de Puerto Montt.
                </li>
                <br>
                <li>
                    <b>Contacto</b>
                    <br>
                    Para consultas, sugerencias o reclamos relacionados con el funcionamiento de la Plataforma o los cursos ofrecidos, los usuarios podrán comunicarse con la Municipalidad a través del formulario de contacto disponible en el sitio web o mediante el correo electrónico oficial <b>contacto@subdelpuertomontt.cl</b>.
                </li>
            </ol>
        </div>
  </div>

</section>




<?= $this->endSection() ?>