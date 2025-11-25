(function ($) {
    'use strict';

    var defaultOptions = {
        serverPath: '/upload_media', // controller en CI4
        deletePath: '/delete_media', // endpoint delete
        fileFieldName: 'file',
        acceptedTypes: ['application/pdf'],
        adminRoute: '/admin'
    };

    // Verifica si estamos en /admin
    function isAdminRoute() {
        return window.location.pathname.includes(defaultOptions.adminRoute);
    }

    // Construye el botón del toolbar
    function buildButtonDef(trumbowyg) {
        return {
            fn: function () {
                const modalContent = `
                    <div class="trumbowyg-input-row">
                        <div class="trumbowyg-input-infos">
                            <label>
                                <span>File</span>
                            </label>
                        </div>
                        <div class="trumbowyg-input-html">
                            <input type="file" id="pdfInput" accept="application/pdf">
                        </div>
                    </div>
                    <div class="trumbowyg-input-row">
                        <div class="trumbowyg-input-infos">
                            <label>
                                <span>Description</span>
                            </label>
                        </div>
                        <div class="trumbowyg-input-html">
                            <input type="text" id="pdfDescription">
                        </div>
                    </div>
                `;

                var $modal = trumbowyg.openModal('Subir archivo PDF', modalContent);
                const $fileInput = $modal.find('#pdfInput');
                const $fileDescription = $modal.find('#pdfDescription');
                const $message = $modal.find('#pdfUploadMessage');

                $modal.on('tbwconfirm', function () {
                    const file = $fileInput[0].files[0];
                    const description = $fileDescription.val() || 'Archivo PDF';

                    if (!file) {
                        $message.text('Debes seleccionar un archivo PDF.');
                        return;
                    }
                    if (file.type !== 'application/pdf') {
                        $message.text('Solo se permiten archivos PDF.');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('description', description);

                    $message.text('Subiendo archivo...');

                    $.ajax({
                        url: trumbowyg.o.plugins.uploadpdf.serverPath,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            if (res.success) {
                                const showDelete = isAdminRoute();
                                const deleteBtn = showDelete
                                    ? `<button type="button" class="delete_media" data-file="${res.file}" style="margin-left:5px;color:black;border:1px solid #ccc;background:#fff;border-radius:4px;cursor:pointer;">🗑</button>`
                                    : '';

                                const linkHtml = `
                                    <span class="pdf-container" contenteditable="false">
                                        <a href="${res.file}" target="_blank" class="uploaded-pdf">${description}</a>
                                        ${deleteBtn}
                                    </span><br>
                                `;

                                // Insertar SIEMPRE al final del contenido
                                const $editor = trumbowyg.$ed;
                                $editor.append(linkHtml);

                                trumbowyg.closeModal();

                            } else {
                                $message.text('Error al subir el archivo.');
                            }
                        },
                        error: function () {
                            $message.text('Error al subir el archivo.');
                        }
                    });
                });

                $modal.on('tbwcancel', function () {
                    trumbowyg.closeModal();
                });
            }
        };
    }

    // Agrega el icono del botón
    function buildButtonIcon() {
        if ($("#trumbowyg-uploadpdf").length > 0) return;
        const iconWrap = $(document.createElementNS("http://www.w3.org/2000/svg", "svg"));
        iconWrap.addClass("trumbowyg-icons");

        iconWrap.html(`
            <symbol id="trumbowyg-uploadpdf" viewBox="0 0 24 24">
                <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 7V3.5L18.5 9H13zM8 13h8v2H8v-2zm0 4h5v2H8v-2z"/>
            </symbol>
        `).appendTo(document.body);
    }

    // Protección contra eliminación manual de PDFs
    function protectPdfContainers(trumbowyg) {
        const $editor = trumbowyg.$ed;

        // Impide borrar o modificar el contenido del contenedor
        $editor.on('keydown', function (e) {
            const sel = window.getSelection();
            if (!sel.rangeCount) return;

            const container = $(sel.anchorNode).closest('.pdf-container');
            if (container.length > 0) {
                // Evita teclas de borrado o escritura dentro del contenedor
                const blockedKeys = ['Backspace', 'Delete', 'Enter'];
                if (blockedKeys.includes(e.key)) {
                    e.preventDefault();
                    return false;
                }
            }
        });

        // Si el usuario intenta pegar algo dentro, evitarlo también
        $editor.on('paste', function (e) {
            const sel = window.getSelection();
            if (sel.rangeCount && $(sel.anchorNode).closest('.pdf-container').length > 0) {
                e.preventDefault();
            }
        });

        // Impide arrastrar o seleccionar el contenido editable del contenedor
        $editor.on('mousedown', '.pdf-container', function (e) {
            e.stopPropagation();
        });
    }

    // Inicializa el plugin
    $.extend(true, $.trumbowyg, {
        langs: {
            es: { uploadpdf: 'Subir PDF' }
        },
        plugins: {
            uploadpdf: {
                init: function (trumbowyg) {
                    trumbowyg.o.plugins.uploadpdf = $.extend(true, {},
                        defaultOptions,
                        trumbowyg.o.plugins.uploadpdf || {}
                    );
                    buildButtonIcon();
                    trumbowyg.addBtnDef('uploadpdf', buildButtonDef(trumbowyg));

                    trumbowyg.$c.on('tbwinit', function() {
                        protectPdfContainers(trumbowyg)
                    });
                }
            }
        }
    });

})(jQuery);
