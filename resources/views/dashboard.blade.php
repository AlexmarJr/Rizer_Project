<x-app-layout>
    <style>
        .wrong{
            border-left: 6px solid red;
            background-color: whitesmoke;
        }
    </style>

    @if(Auth::user()->position != 'admin')
    <script>
        $( document ).ready(function() {
            $("#profile-tab").click();
        });
    </script>
    @endif

    <x-slot name="header">
        <h2 style="text-align: center"> 
           @if(Auth::user()->position == "admin") Administrador @else Vendendor/Tecnico @endif
        </h2>
    </x-slot>


    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @if(Auth::user()->position == "admin")
                <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Funcionarios</a>
                </li>
            @endif
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Chamados Abertos</a>
            </li>
          </ul>

          <div class="tab-content" id="myTabContent">
            @if(Auth::user()->position == "admin")
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="form">
                        <button type="button" class="btn btn-primary" onclick="open_modal()">
                            <i class="fa fa-plus"></i> Funcionario
                        </button>

                        <table class="table" id="datatable">
                            <thead> 
                                <tr>
                                    <th width="40%">Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Posição</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

                @if(Auth::user()->position == 'admin')
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-3">
                                Chamados em Aberto: <b style="color: blue">{{ $data['tickets']['open'] }}</b>
                            </div>
                            <div class="col-3">
                                Chamados em Andamento: <b style="color: blue">{{ $data['tickets']['ongoing'] }}</b>
                            </div>
                            <div class="col-3">
                                Chamados Atrasados: <b style="color: red">{{ $data['tickets']['delayed'] }}</b>
                            </div>
                            <div class="col-3">
                                Chamados Concluidos: <b style="color: green">{{ $data['tickets']['concluded'] }}</b>
                            </div>
                        </div>
                        <table class="table" id="chamados">
                            <thead> 
                                <tr>
                                    <th width="40%">Nome</th>
                                    <th>Email</th>
                                    <th>Chamados Abertos</th>
                                    <th>Chamados Andamento</th>
                                    <th>Chamados Atrasados</th>
                                    <th>Chamados Concluidos</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($data['users'] as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->tickets_open }}</td>
                                        <td>{{ $user->tickets_ongoing }}</td>
                                        <td>{{ $user->tickets_delayed }}</td>
                                        <td>{{ $user->tickets_solved }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                @else
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table" id="chamados_seller">
                        <thead> 
                            <tr>
                                <th width="40%">Nome</th>
                                <th>Email</th>
                                <th>Assunto</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
                @endif

          </div>
    </div>
   

<!-- ----------Modal------------- -->

    <!-- Modal Do Funcionario -->
    <div class="modal fade" id="seller_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="seller_modal">Adicionar Funcionario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_seller" value="">
                <div class="row">
                    <div class="col-12">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="col-12">
                        <label for="email">E-Mail</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="col-6">
                        <label for="phone">Telefone</label>
                        <input type="text" class="form-control phone-mask" name="phone" id="phone" required>
                    </div>
                    <div class="col-6">
                        <label for="position">Posição</label>
                        <select name="position" id="position" class="form-control">
                            <option value="seller">Vendendor/Tecnico</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control wrong" name="password" id="password" required onkeyup="check_password()">
                    </div>
                    <div class="col-6">
                        <label for="confirm_password">Confirmar Senha</label>
                        <input type="password" class="form-control wrong" name="confirm_password" id="confirm_password" required onkeyup="check_password()">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-success" onclick="verify_and_save('save')" id="save_btn">Salvar</button>
            <button type="button" class="btn btn-primary" onclick="verify_and_save('update')" style="display: none" id="update_btn">Alterar</button>
            </div>
        </div>
        </div>
    </div>


    <!-- Modal Do Ticket -->
    <div class="modal fade" id="ticket_info" tabindex="-1" role="dialog" aria-labelledby="ticket_infoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ticket_infoLabel">Ocorrencia</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_ticket">
                <div class="row">
                    <div class="col-6">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" name="name_client" id="name_client" readonly>
                    </div>
                    <div class="col-6">
                        <label for="email">E-Mail</label>
                        <input type="email" class="form-control" name="email_client" id="email_client" readonly>
                    </div>
                    <div class="col-12">
                        <label for="name">Assunto </label>
                        <input type="text" class="form-control" name="subject" id="subject" readonly>
                    </div>
                    <div class="col-12">
                        <label for="name">Descrição </label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="3" readonly></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
              <button type="button" class="btn btn-primary" onclick="close_ocorrencia()" id="btn_close_ticket">Concluir Ocorrencia</button>
            </div>
          </div>
        </div>
      </div>

    <script>
    $(document).ready( function () {
        $('#datatable').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            info: false,
            language: {
                search: "Buscar"
            }
        });
        $('#chamados').DataTable({
            responsive: true,
            paging: false,
            searching: true,
            info: false,
            language: {
                search: "Buscar"
            }
        });
    } );

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // --------------------------------------------- Inicio dos Scripts para Funcionarios ---------------------------------------- //

    function getRecords() { 
        $.ajax({
            url: "{{ route('get_records') }}",
            type: "get",
            dataType: 'json',
            success: function (data) {
                var s = '';
                
                var html='';
                data.forEach(function(row){
                    //if(row.price == "Ativo"){ s = 'color: green'}else{s = 'color: red'};
                    html += '<tr>'
                    html += '<td>' + row.name + '</td>'
                    html += '<td>' + row.email + '</td>'
                    html += '<td>' + row.phone + '</td>'
                    html += '<td> ' + ((row.position == 'admin') ? "Administrador" : "Vendedor/Tecnico") + ' </td>'
                    html += ((row.status == '1') ? "<td style='color: green'> Ativo" : "<td style='color: red'> Desativado") + ' </td>'
                    html += '<td>'
                    html += '<button  class="btn btnEdit" data-id="' + row.id + '" title="Edit Record" ><i class="fa fa-info-circle"></i></button> &nbsp ' + ((row.status == '1') ? '<button class="btn btn-danger" title="Desativar" onclick="change_status(' + row.id + ', '+ 0 +')"><i class="fa fa-minus-circle"></i></button>' : '<button class="btn btn-success" title="Ativar" onclick="change_status(' + row.id + ', '+ 1 +')"><i class="fa fa-plus-circle"></i></button>') + ' '
                    html += '</td> </tr>';
                })
                    $('#datatable').DataTable().destroy();
                    $('#datatable tbody').html(html);
                 
                    $('#datatable').DataTable({
                        responsive: true,
                        paging: false,
                        searching: true,
                        info: false,
                        language: {
                            search: "Buscar"
                        }
                    });
                
                }
        })
    }
    getRecords()

        function check_password(action){
            //Checka se as 2 senhas são iguais
            var password = $("#password").val();
            var check_password = $("#confirm_password").val();
            if(password == check_password && password != ''){
                $("#password").css({'border-left':'6px solid green'});
                $("#confirm_password").css({'border-left':'6px solid green'});
                return 1;
            }
            else if(action == 'update' && password == '' && check_password == ''){
                $("#password").css({'border-left':'6px solid green'});
                $("#confirm_password").css({'border-left':'6px solid green'});
                return 1;
            }
            else{
                $("#password").css({'border-left':'6px solid red'});
                $("#confirm_password").css({'border-left':'6px solid red'});
                return 0;
            }
        }

        function verify_and_save(action){
            var name = $("#name").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();


            //Lembro que tinha um forma melhor de fazer essa verificação, mas esqeuci, fica pra proxima
            if(name == ''){
                $("#name").css({'border-left':'6px solid red'});
                return 0;
            }
            else{
                $("#name").css({'border-left':'6px solid green'});
            }
            if(email == ''){
                $("#email").css({'border-left':'6px solid red'});
                return 0;
            }
            else{
                $("#email").css({'border-left':'6px solid green'});
            }
            if(phone == ''){
                $("#phone").css({'border-left':'6px solid red'});
                return 0;
            }
            else{
                $("#phone").css({'border-left':'6px solid green'});
            }

            var verify_password = check_password(action);
            if(verify_password == 1){
                if(action == 'save'){
                    post_data();
                }
                else{
                    update_data();
                }
            }
            else{
                swal.fire('Senha Devem estar iguais', '', 'warning');
            }
            
        }

        function post_data(){
            $.ajax({
            type: 'POST',
            url: "{{ route('save_seller') }}",
            data: {
                'name':  $("#name").val(),
                'email':  $("#email").val(),
                'phone': $('#phone').val(),
                'position': $('#position').val(),
                'password': $('#password').val(),
            },
            success: function(response) {
                if(response != ''){
                    swal.fire('Email já Existe', 'Pertence á: '+ response.name +'', 'warning');
                    $("#email").css({'border-left':'10px solid red'});
                }
                else{
                    swal.fire('Funcionario Registrado', '', 'success');
                    $('#name').val('');
                    $('#email').val('');
                    $('#phone').val('');
                    $('#password').val('');
                    $('#confirm_password').val('');
                    $('#seller_modal').modal('hide');
                    getRecords();
                }
            },
            error: function() {
                swal.fire('Erro Não identificado', 'Porfavor consulte a equipe de desenvolvimento', 'error');
           }
        });
        }

        function update_data(){
            $.ajax({
            type: 'POST',
            url: "{{ route('update_seller') }}",
            data: {
                'id':  $("#id_seller").val(),
                'name':  $("#name").val(),
                'email':  $("#email").val(),
                'phone': $('#phone').val(),
                'position': $('#position').val(),
                'password': $('#password').val(),
            },
            success: function(response) {
                if(response != ''){
                    swal.fire('Email já Existe', 'Pertence á: '+ response.name +'', 'warning');
                    $("#email").css({'border-left':'10px solid red'});
                }
                else{
                    swal.fire('Funcionario Atualizado!', '', 'success');
                    $("#id_seller").val('')
                    $('#name').val('');
                    $('#email').val('');
                    $('#phone').val('');
                    $('#password').val('');
                    $('#confirm_password').val('');
                    $('#seller_modal').modal('hide');
                    getRecords();
                }
            },
            error: function() {
                swal.fire('Erro Não identificado', 'Porfavor consulte a equipe de desenvolvimento', 'error');
           }
        });
        }

        $('table').on('click', '.btnEdit', function () {
            var id = $(this).data('id');
            $.ajax({
                    url:"/get_seller/" + id,
                    type: "get",
                    dataType: 'json',
                success: function (response) {
                    $('#name').val(response.name);
                    $('#phone').val(response.phone);
                    $('#email').val(response.email);
                    $('#position').val(response.position);
                    $('#id_seller').val(response.id);
                    $('#seller_modal').modal('show');         
                    $("#update_btn").css({'display':'block'});
                    $("#save_btn").css({'display':'none'});
                }
            })
        }) 

        function open_modal(){
            $('#name').val('');
            $('#email').val('');
            $('#phone').val('');
            $('#password').val('');
            $('#confirm_password').val('');
            $("#update_btn").css({'display':'none'});
            $("#save_btn").css({'display':'block'});
            $('#seller_modal').modal('show');
        }

        function change_status(id, status){
            //Desativa ou ativa um usuario, a variavel Status que vai dizer qual ação vai ser tomada.
                $.ajax({
                    url:"/change_status/" + id + "/" + status,
                    type: "get",
                    dataType: 'json',
                success: function (response) {
                    swal.fire('O Status do Usuario foi Modificado!', '', 'warning');
                    getRecords();
                },
                error: function() {
                swal.fire('Erro Não identificado', 'Porfavor consulte a equipe de desenvolvimento', 'error');
                }
            })
        }

        // --------------------------------------------- Fim dos Scripts para Funcionarios ---------------------------------------- //
        


        // --------------------------------------------- Inicio dos Scripts para Chamados ---------------------------------------- //

    function getAllTickets() { 
        //Função puxa dados atualizados dos tickets, fazendo assim todas ações serem assyncronas
        let data = new Date();

        //Captura a data atual tirando 1 Dia e formata para comparar com o created_at.
        let dataFormatada = (data.getFullYear() + "-" + ((data.getMonth() < 9) ? '0': '') + ((data.getMonth() + 1)) + "-" + (data.getDate() - 1 )) ;       
        $.ajax({
            url: "{{ route('get_all_tickets') }}",
            type: "get",
            dataType: 'json',
            success: function (data) {
                var s = '';
                var created_at = '';
                var html='';
                data.forEach(function(row){
                    html += '<tr>' 
                    html += '<td>' + ((row.name_client == null)? "Não Optante": row.name_client) + '</td>'
                    html += '<td>' + ((row.email_client == null)? "Não Optante": row.email_client) + '</td>'
                    html += '<td>' + row.subject + '</td>'
                    html += '<td>' + row.open_date + '</td>'

                    /*
                    Esse If serve para que o sistema saiba se deve botar o chamado em aberto ou andamento ou se ja está vencido
                    Já que não tem um status de vencido.
                    */
                    if(row.status == '1' && row.open_date >= dataFormatada ){
                        html += "<td style='color: blue'> Aberto </td>"
                    }
                    else if(row.status == '2' && row.open_date >= dataFormatada){
                        html += "<td style='color: blue'> Em Andamento </td>"
                    }
                    else if((row.status == '2' || row.status == '1') && row.open_date < dataFormatada){
                        html += "<td style='color: red'> Atrasado </td>"
                    }
                    else{
                        html += "<td style='color: green'> Concluido </td>"
                    }
                    html += '<td>'
                    html += '<button  class="btn openTicket" data-id="' + row.id + '" title="Edit Record" ><i class="fa fa-info-circle"></i></button>'
                    html += '</td> </tr>';
                })

                    $('#chamados_seller').DataTable().destroy();
                    $('#chamados_seller tbody').html(html);
                 
                    $('#chamados_seller').DataTable({
                        responsive: true,
                        paging: false,
                        searching: true,
                        info: false,
                        language: {
                            search: "Buscar"
                        }
                    });
                
                }
        })
    }
    getAllTickets();

    
    $('table').on('click', '.openTicket', function () {
            var id = $(this).data('id');
            $.ajax({
                    url:"/get_ticket/" + id,
                    type: "get",
                    dataType: 'json',
                success: function (response) {
                    if(response.status == 3){ //Faz o Botão de Fechar ocorrencia sumir caso a ocorrencia ja tenha sido concluida
                        $("#btn_close_ticket").css({'display':'none'});
                    }
                    else{
                        $("#btn_close_ticket").css({'display':'block'});
                    }
                    $('#name_client').val(response.name_client);
                    $('#email_client').val(response.email_client);
                    $('#subject').val(response.subject);
                    $('#description').val(response.description);
                    $('#id_ticket').val(response.id);
                    $("#ticket_info").modal('show');

                    getAllTickets(); //Chama novamente a fubção para recriar a tabela com o dados Atualizados
                }
            })
    }) 

    function close_ocorrencia(){
        $.ajax({
                url:"/close_ticket/" + $("#id_ticket").val(),
                type: "get",
                dataType: 'json',
            success: function (response) {
                swal.fire('A Ocorrencia Foi Finalizada!', '', 'success');
                $('#name_client').val('');
                $('#email_client').val('');
                $('#subject').val('');
                $('#description').val('');
                $('#id_ticket').val('');
                $("#ticket_info").modal('hide');

                getAllTickets();

            },
            error: function() {
                swal.fire('Erro Não identificado', 'Porfavor consulte a equipe de desenvolvimento', 'error');
            }
        })
    }

        // --------------------------------------------- Fim dos Scripts para Chamados ---------------------------------------- //
    </script>
</x-app-layout>
