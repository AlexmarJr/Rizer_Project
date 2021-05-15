<x-app-layout>
    <style>
        .wrong{
            border-left: 6px solid red;
            background-color: whitesmoke;
        }
    </style>

<x-slot name="header">
        <h2 style="text-align: center"> 
            Administrador
        </h2>
    </x-slot>


    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Funcionarios</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Chamados Abertos</a>
            </li>
          </ul>
            <hr>

          <div class="tab-content" id="myTabContent">
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


            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            </div>
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
                <input type="hidden" id="id_seller">
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
            <button type="button" class="btn btn-success" onclick="verify_and_save()">Salvar</button>
            <button type="button" class="btn btn-primary" onclick="verify_and_save()" style="display: none" id="update_btn">Alterar</button>
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
            info: false
        });
    } );

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
                    $('table tbody').html(html);
                 
                    $('#datatable').DataTable({
                        responsive: true,
                        paging: false,
                        searching: false,
                        info: false
                    });
                
                }
        })
    }
    getRecords()

        function check_password(){
            var password = $("#password").val();
            var check_password = $("#confirm_password").val();
            if(password == check_password && password != ''){
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

        function verify_and_save(){
            var name = $("#name").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();

            if(name == ''){
                $("#name").addClass("wrong");
                return 0;
            }
            else{
                $("#name").css({'border-left':'6px solid green'});
            }
            if(email == ''){
                $("#email").addClass("wrong");
                return 0;
            }
            else{
                $("#email").css({'border-left':'6px solid green'});
            }
            if(phone == ''){
                $("#phone").addClass("wrong");
                return 0;
            }
            else{
                $("#phone").css({'border-left':'6px solid green'});
            }

            var verify_password = check_password();
            if(verify_password == 1){
                post_data();
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
                }
            })
        }) 

        function open_modal(){
            $('#name').val('');
            $('#email').val('');
            $('#phone').val('');
            $('#password').val('');
            $('#confirm_password').val('');
            $('#seller_modal').modal('show');
        }

        function change_status(id, status){
     
                $.ajax({
                    url:"/change_status/" + id + "/" + status,
                    type: "get",
                    dataType: 'json',
                success: function (response) {
                    swal.fire('Usuario Modificado!', '', 'warning');
                    getRecords();
                },
                error: function() {
                swal.fire('Erro Não identificado', 'Porfavor consulte a equipe de desenvolvimento', 'error');
                }
            })
        }
    </script>
</x-app-layout>
