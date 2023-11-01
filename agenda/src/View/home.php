<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<body>
    <div class="container">
        <h1 class="my-4">Prova Magazord - Agenda</h1>
        <div class="input-group mb-3 mt-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar por nome...">
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2>Pessoas <button class="btn btn-success" onClick="incluirPessoa()"><i class="fas fa-plus"></i> Incluir</button></h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CPF</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($args['pessoas'] as $Pessoa) {
                            echo '<tr>';
                            echo '<td>' . $Pessoa->getId() . '</td>';
                            echo '<td>' . $Pessoa->getNome() . '</td>';
                            echo '<td>' . $Pessoa->getCpf() . '</td>';
                            echo '<td><button class="btn btn-primary" data-id="'.$Pessoa->getId().'" onClick="editarPessoa(this)">Editar</button></td>';
                            echo '<td><button class="btn btn-primary" onclick="deleteRegistro(`pessoa`, '.$Pessoa->getId().')">Excluir</button></td>';
                            echo '<td><button class="btn btn-success" data-toggle="modal" onClick="incluirContato('.$Pessoa->getId().')"><i class="fas fa-plus"></i> Add Contato</button></td>';
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h2>Contatos</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pessoa</th>
                            <th>Tipo</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($args['contatos'] as $Contato) {
                            echo '<tr>';
                            echo '<td>' . $Contato->getId() . '</td>';
                            echo '<td>' . $Contato->getPessoa()->getId() . ' - ' . $Contato->getPessoa()->getNome() . '</td>';
                            echo '<td>' . $Contato->getTipoDescritivo() . '</td>';
                            echo '<td>' . $Contato->getDescricao() . '</td>';
                            echo '<td><button class="btn btn-primary" onClick="editarContato(this)">Editar</button></td>';
                            echo '<td><button class="btn btn-primary" onclick="deleteRegistro(`contato`, '.$Contato->getId().')">Excluir</button></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        async function abrePopupManutencaoPessoa(pessoa, titulo, action, fnCallback){
            Swal.close();

            const { value: formValues } = await Swal.fire({
                title: titulo,
                html:
                    '<form id="formulario">' +
                    '<div class="mb-3">' +
                    '<input type="hidden" id="pessoaId" value="' + pessoa[0] + '"> ' +
                    '</div>' +
                    '<div class="mb-3">' +
                    '<label for="nome" class="form-label">Nome:</label>' +
                    '<input type="text" class="form-control" id="pessoaNome" value="'+pessoa[1]+'">' +
                    '</div>' +
                    '<div class="mb-3">' +
                    '<label for="cpf" class="form-label">CPF:</label>' +
                    '<input type="text" class="form-control" id="pessoaCpf" value="'+pessoa[2]+'" maxLength="11">' +
                    '</div>' +
                    '</form>',
                showCancelButton: true,
                confirmButtonText: 'Salvar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    return {
                        id: document.getElementById('pessoaId').value,
                        nome: document.getElementById('pessoaNome').value,
                        cpf: document.getElementById('pessoaCpf').value
                    };
                }
            });

            if(formValues){
                carregando();
                var data = {
                    id: formValues.id,
                    nome: formValues.nome,
                    cpf: formValues.cpf,
                    target: 'pessoa',
                    action: action
                };

                realizaRequest(data, fnCallback);
            }
        }

        function editarPessoa(botao) {
            const linha = botao.parentNode.parentNode;
            const celulas = linha.getElementsByTagName('td');
            var pessoa = [];
            for (let i = 0; i < celulas.length; i++) {
                pessoa.push(celulas[i].textContent);
            }
            carregando();
            var fnCallback = function () { 
                Swal.close();
                Swal.fire({
                    title: 'Pessoa Editada',
                    icon: 'success'
                }).then((result) => {
                    atualizaPagina();
                });
            };

            abrePopupManutencaoPessoa(pessoa, 'Editar Pessoa', 'edit', fnCallback);
        };


        function incluirPessoa() {
            carregando();
            var pessoa = ['','',''];
            var fnCallback = function () { 
                Swal.close();
                Swal.fire({
                    title: 'Pessoa Incluída',
                    icon: 'success'
                }).then((result) => {
                    atualizaPagina();
                });
            };

            abrePopupManutencaoPessoa(pessoa, 'Incluir Pessoa', 'create', fnCallback);
        };

        async function abrePopupManutencaoContato(contato, titulo, action, fnCallback){
            Swal.close();
            debugger;
            var telefoneSelecionado = (contato[2] === 'Telefone') ? 'selected' : '';
            var emailSelecionado = (contato[2] === 'Email') ? 'selected' : '';

            const { value: formValues } = await Swal.fire({
                title: titulo,
                html:
                '<form id="formulario">' +
                '<div class="mb-3">' +
                '<input type="hidden" id="idContato" value="'+contato[0]+'"> ' + 
                '<input type="hidden" id="idPessoaContato" value="'+contato[1]+'"> ' + 
                '</div>' +
                '<div class="mb-3">' +
                '<label for="tipo">Tipo:</label>' +
                '<select class="form-select" id="tipo">' +
                '<option value="1" '+telefoneSelecionado+'>Telefone</option>' +
                '<option value="2" '+emailSelecionado+'>Email</option>' +
                '</select>' +
                '</div>' +
                '<div class="mb-3">' +
                '<label for="descricao">Descrição:</label>' +
                '<input type="text" class="form-control" id="descricao" value="'+contato[3]+'">' +
                '</div>' +
                '</form>',
                showCancelButton: true,
                confirmButtonText: 'Salvar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    return {
                        idPessoaContato: document.getElementById('idPessoaContato').value,
                        id: document.getElementById('idContato').value,
                        tipo: document.getElementById('tipo').value,
                        descricao: document.getElementById('descricao').value
                    };
                }
            });

            if(formValues){
                carregando();
                var data = {
                    id: formValues.id,
                    descricao: formValues.descricao,
                    tipo: formValues.tipo,
                    pessoaId: formValues.idPessoaContato,
                    target: 'contato',
                    action: action
                };

                realizaRequest(data, fnCallback);
            }
        }

        function editarContato(botao) {
            const linha = botao.parentNode.parentNode;
            const celulas = linha.getElementsByTagName('td');
            var contato = [];
            for (let i = 0; i < celulas.length; i++) {
                var value = celulas[i].textContent;
                if(i == 1){
                    var idPessoa = value.split(' - ');
                    value = idPessoa[0];
                }
                contato.push(value);
            }
            carregando();
            var fnCallback = function () { 
                Swal.close();
                Swal.fire({
                    title: 'Contato Editado',
                    icon: 'success'
                }).then((result) => {
                    atualizaPagina();
                });
            };

            abrePopupManutencaoContato(contato, 'Editar Contato', 'edit', fnCallback);
        };


        function incluirContato(idPessoa) {
            carregando();
            var contato = ['',idPessoa,'',''];
            var fnCallback = function () {
                Swal.close();
                Swal.fire({
                    title: 'Contato Incluído',
                    icon: 'success'
                }).then((result) => {
                    atualizaPagina();
                });
            };

            abrePopupManutencaoContato(contato, 'Incluir Contato', 'create', fnCallback);
        };

        function carregando() {
            Swal.fire({
                title: 'Carregando...',
                allowOutsideClick: false,
                showConfirmButton: false
            });
        };

        function deleteRegistro(target, id) {
            Swal.fire({
                title: 'Deseja deletar o registro?',
                text: "Não será possível reverter esta ação!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        carregando();
                        var data = {
                            id: id,
                            target: target,
                            action: 'delete'
                        };
                        realizaRequest(data, () => {
                            Swal.close();
                            Swal.fire(
                            'Registro deletado!',
                            'Seu registro foi deletado com sucesso.',
                            'success'
                            ).then((result) => {
                                atualizaPagina();
                            });
                        });
                    }
                });                       
        }

        function manutencaoPessoa(namefunction) {
            carregando();
            var campoId  = document.getElementById('id');
            var campoNome = document.getElementById('nome');
            var campoCpf  = document.getElementById('cpf');
            var popup = $('#popupManutencao');

            var data = {
                id: campoId.value,
                nome: campoNome.value,
                cpf: campoCpf.value,
                target: 'pessoa',
                action: namefunction
            };

            realizaRequest(data, () => {
                Swal.close();
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Registro incluído com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    atualizaPagina();
                });
            });           
        }

        function atualizaPagina(){
            location.reload();
        }

        function realizaRequest(data, fnCallback){
            fetch('request.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.text())
            .then(resposta => {
                debugger;
                if(resposta){
                    fnCallback(resposta);
                }
            })
            .catch(error => {
                console.error(error);
            });
        }

        $('#editModalContato').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('#id').val(id);
            if(button.data('name') == 'editar'){
                var campoNome = modal.find('#nome');
                var campoCpf  = modal.find('#cpf');
                console.log(campoNome);
            }
        });

        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', filterTable);

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const tableRows = document.querySelectorAll('table tbody tr');

            tableRows.forEach(row => {
                const nome = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (nome.includes(searchText)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
    
</body>
</html>
