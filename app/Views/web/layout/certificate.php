<style>
    table{
        border-collapse: collapse; 
        width:100%; 
    }
</style>
<page backtop="14mm" backbottom="14mm" backleft="15mm" backright="20mm"> 
    <page_header> 
         
    </page_header> 
    <page_footer> 
         
    </page_footer> 
    
    <div>
        <table border="0">
            <tr>
                <td>
                    <img src="../public/img/logo_test.png" alt="" style="width:200px; height:auto;">
                </td>
                <td width="500" style="height:100px; text-align:center; vertical-align:middle;">
                    <h2>CERTIFICADO DE FINALIZACIÓN</h2>
                </td>
                <td style="text-align:right;">
                    <img src="../public/img/logo_muni_2.png" alt="" style="width:280px; height:auto;margin-top:15px;">
                </td>
                
            </tr>
            <tr>
                <td colspan="3" height="320" style="vertical-align:middle;">
                    <h1 style="font-size:80px;"><?= $course->course_name ?></h1>
                    <p style="font-size:20px;line-height:1.5;">Municipalidad de Puerto Montt<br>
                    Subdirección de Desarrollo Económico Local</p>
                </td>
            </tr>
            <tr>
                <td colspan="3" height="150" style="text-align:right;vertical-align:top;">
                    <p style="font-size:20px;line-height:1.5;">
                        <h2 style="font-size:40px;margin-bottom:0;margin-top:0;"><?= $course->name.' '.$course->lastname ?></h2>
                        Fecha <b><?= beautiful_date($course->updated_at) ?></b>
                        <br>
                        Duración del curso <b><?= round_duration_to_hours($course->duration) ?> horas</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="font-size:14px;text-align:left;line-height:1.5;">
                    Código verificación: <?= $course->code ?>
                    <br>
                    Token certificado: <?= $course->token ?>
                    <br>
                    URL certificado: <?= base_url('verify-certificate?&token='.$course->token) ?>
                </td>
            </tr>
        </table>

    </div>
    
</page> 

