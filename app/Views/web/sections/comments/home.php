<?php

use App\Models\CommentModel;
$uri = service('uri');
$section = $uri->getSegment(1);
$id = $uri->getSegment(3);
?>
<?php if( isset(auth()->user()->id)): ?>  
<!-- Edit Comment Modal -->
<div class="modal fade" id="updateCommentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Comentario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('comment/update')?>" method="POST">
                    <input type="hidden" name="tbl_comment_id" id="updateCommentID">
                    <div class="form-group">
                        <label for="updateCommentator">Nombre</label>
                        <input type="hidden" name="commentator_id" value="<?= auth()->user()->id ?>">
                        <input type="text" class="form-control" name="commentator" id="updateCommentator" value="<?= auth()->user()->name.' '.auth()->user()->lastname ?>" disabled readonly>
                    </div>
                    <div class="form-group">
                        <label for="updateComment">Comentario</label>
                        <textarea name="comment" id="updateComment" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Add Reply Modal -->
<div class="modal fade" id="replyCommentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Responder a <b><span id="replyTo"></span></b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('comment/create') ?>" method="POST">
                    <input type="hidden" id="replyCommentID" name="tbl_comment_id">
                    <div class="form-group">
                        <label for="replier">Nombre</label>
                        <input type="hidden" name="commentator_id" value="<?= auth()->user()->id ?>">
                        <input type="text" class="form-control" name="commentator" id="commentator" value="<?= auth()->user()->name.' '.auth()->user()->lastname ?>" disabled readonly>
                    </div>
                    <div class="form-group">
                        <label for="reply">Responder</label>
                        <textarea name="comment" id="reply" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Responder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Reply Modal -->
<div class="modal fade" id="updateReplyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Respuesta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('comment/update')?>" method="POST">
                    <input type="hidden" id="updateReplyID" name="tbl_reply_id">
                    <div class="form-group">
                        <label for="updateReplier">Nombre</label>
                        <input type="text" class="form-control" name="replier" id="updateReplier">
                    </div>
                    <div class="form-group">
                        <label for="updateReply">Respuesta</label>
                        <textarea name="reply" id="updateReply" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="main">

    <div class="comment-container">
        
        <h2 class="mb-4">
            Comentarios
        </h2>

        <?php
        if (session('error') !== null) {
            showFlashMessage('error', session('error'));
        } elseif (session('errors') !== null) {
            showFlashMessage('error', implode('<br>', session('errors')));
        } elseif (session('success') !== null) {
            showFlashMessage('success', session('success'));
        }
        ?>

        <div class="write-comment">
            <?php if( isset(auth()->user()->id)): ?>   
            <form action="<?= base_url('comment/create') ?>" method="POST">

                <input type="hidden" id="section" name="section" value="<?= $section; ?>">
                <input type="hidden" id="section_id" name="section_id" value="<?= $id; ?>">
                <div class="form-group mb-3">
                    <label for="commentator"><b>Nombre</b></label>
                    <input type="hidden" name="commentator_id" value="<?= auth()->user()->id ?>">
                    <input type="text" class="form-control" name="commentator" id="commentator" value="<?= auth()->user()->name.' '.auth()->user()->lastname ?>" disabled readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="comment"><b>Comentario</b></label>
                    <textarea name="comment" id="comment" class="form-control" cols="30" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-success form-control mb-3 submit_something">
                    Publicar
                </button>
            </form>
            <?php else: ?>
                <p>Registrate y/o inicia sesión para comentar.</p>
            <?php endif; ?>
        </div>
        <?php
        foreach ($comments as $row) {
            $commentID = $row["id"];
            $commentator_id = $row['commentator_id'];
            $commentator = $row["commentator"];
            $comment = $row["comment"];
            $tdComment = $row["created_at"];
            ?>

            <div id="comments_list" class="comment pt-3">

                <div id="comment_header" class="d-flex align-items-center">
                    <input type="hidden" id="commentID-<?= $commentID ?>" value="<?= $commentID ?>">
                    <i class="bi bi-person-circle fs-2 me-3 text-success"></i>
                    <strong class="flex-grow-1" id="commentator-<?= $commentID ?>"><?= $commentator ?></strong>
                    <em class="ms-2 text-secondary" id="tdComment-<?= $commentID ?>">
                    <?= blog_datetime($tdComment) ?> 
                    </em>
                    <br>
                </div>

                <p class="ms-5 mb-1" id="comment-<?= $commentID ?>"><?= $comment ?></p>

                <div class="comment-option text-secondary">
                    <!--
                    <label class="like">
                        <input type="checkbox">
                        <i class="bi bi-hand-thumbs-up-fill"></i>
                    </label>
                    -->
                    <?php if(isset(auth()->user()->id) && $commentator_id == auth()->user()->id): ?>
                    <button class="btn btn-link px-1 reply-button" onclick="replyComment(<?= $commentID ?>)">
                        <b><i class="bi bi-chat-dots"></i> Responder</b>
                    </button>
                    <button class="btn btn-link px-1 edit-button" onclick="updateComment(<?= $commentID ?>)">
                        <i class="bi bi-pencil-square"></i> Editar
                    </button>
                    <a class="btn btn-link px-1 edit-button" href="<?= base_url('comment/delete?comment_id=' . $commentID) ?>" onclick="return confirm('¿Quiere eliminar este comentario?');">
                        <i class="bi bi-trash3"></i> Borrar
                    </a>
                    <?php endif; ?>
                </div>

                <?php
                $stmt = model(CommentModel::class);
                $resp = $stmt->select('comments.*, CONCAT(users.name," ", users.lastname) AS commentator')
                             ->join('users', 'users.id = comments.commentator_id')
                             ->where('parent_comment_id', $commentID)->get()->getResultArray();

                foreach ($resp as $row) {
                    $replyID = $row["id"];
                    $replier_id = $row['commentator_id'];
                    $replier = $row["commentator"];
                    $reply = $row["comment"];
                    $tdReply = $row["created_at"];
                ?>
                    <div class="d-flex align-items-center ms-5 mt-3">
                        <div class="fs-2 text-secondary">
                            <i class="bi bi-arrow-return-right"></i>
                        </div>
                        <div class="ms-3 reply w-100">
                            <input type="hidden" id="replyID-<?= $replyID ?>" name="tbl_reply_id" value="<?= $replyID ?>">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle fs-2 me-3 text-success"></i>
                                <strong class="flex-grow-1" id="replier-<?= $replyID ?>"><?= $replier ?></strong>
                                <em class="ms-2 text-secondary">
                                <?= blog_datetime($tdReply) ?> 
                                </em>
                                <br>
                            </div>

                            <p class="ms-5 mb-1" id="reply-<?= $replyID ?>"><?= $reply ?></p>

                            <div class="comment-option text-secondary">
                                <!--
                                <label class="like">
                                    <input type="checkbox">
                                    <i class="bi bi-hand-thumbs-up-fill"></i>
                                </label>
                                -->
                                <?php if( isset(auth()->user()->id ) && $replier_id == auth()->user()->id): ?>
                                <button class="btn btn-link edit-button px-1" href="#" onclick="updateReply(<?= $replyID ?>)">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </button>
                                <a class="btn btn-link edit-button px-1" href="<?= base_url('comment/delete?comment_id=' . $replyID) ?>" onclick="return confirm('¿Quiere eliminar esta respuesta?')">
                                    <i class="bi bi-trash3"></i> Borrar
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        <?php 
            } 
            echo empty($comment_pager) ? $comment_pager->links('res', 'bootstrap') : '';
        ?>

    </div>

</div>