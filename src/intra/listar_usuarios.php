<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 8/31/15
 * Time: 11:31 AM
 */
$usuario = new Usuario();
$dados = $usuario->getUsuarios();
?>

<div class="container">
    <ul class="breadcrumb">
        <li><a href="principal.php">Início</a> <span class="divider">/</span></li>
        <li class="active">Usuários</li>
    </ul>
    <div id="atualizadoSucesso" class="alert alert-success hide">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Conteúdo atualizado com sucesso.
    </div>
    <h3>Listar Usuários</h3>
    <!-- Button to trigger modal -->
    <a href="#adicionarUsuario" role="button" class="btn btn-primary" data-toggle="modal">Adicionar usuario</a>
    <button class="btn btn-secundary" onclick="window.location.href = 'principal.php';" type="button" id="btnVoltar"  >Voltar</button>
    <!-- Modal -->
    <div id="adicionarUsuario" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="adicionarUsuarioLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="adicionarUsuarioLabel">Adicionar usuário</h3>
        </div>
        <div class="modal-body">
            <form id="userForm">
                <div class="pull-left">
                    <div class="control-group">
                        <label for="nome" class="control-label">Nome</label>
                        <div class="controls">
                            <input type="text" placeholder="nome" id="nome" name="nome" required="" class="input-xlarge" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="sobrenome" class="control-label">Sobrenome</label>
                        <div class="controls">
                            <input type="text" placeholder="sobrenome" id="sobrenome" name="sobrenome" required="" class="input-xlarge" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="email" class="control-label">Email</label>
                        <div class="controls">
                            <input type="text" placeholder="email" id="email" name="email" required="" class="input-xlarge" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="senha" class="control-label">Senha</label>
                        <div class="controls">
                            <input type="password" placeholder="senha" id="senha" name="senha" required="" class="input-xlarge" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="confirmsenha" class="control-label">Repita a senha</label>
                        <div class="controls">
                            <input type="password" placeholder="senha" id="confirmsenha" name="confirmsenha" required="" class="input-xlarge" value="">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
            <button class="btn btn-primary" data-dismiss="modal" onclick="adicionarUsuario();">Adicionar</button>
        </div>
    </div>

    <?php //$usuario->gerarModaisEditar(); ?>
    <hr />
    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php $usuario->getUsuariosTable(); ?>
        </tbody>
    </table>
    <hr />




</div> <!-- /container -->
<script>
    $(document).ready(function() {
        $('#userForm').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                confirmPassword: {
                    validators: {
                        identical: {
                            field: 'password',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                }
            }
        });
    });
</script>