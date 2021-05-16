--------------Observações Gerais--------------- <br>
*Como não foi requisitado nos detalhes do desafio, O cliente não tem um login valido, e so pode abrir um chamado na tela principal.

*Não foi requisitado um perfil administrador no sistema, mas preferi implementar por fazer mais sentido no geral.

*Maior parte do sistema está funcinando de forma Assyncrona, usando Ajax, so a parte do administrador acompanhar os chamados que está sem ser assyncrono, pelo fato de não ter nenhum tipo de interação nessa tela.

*Sistema ta responsivo para mobile.

*Não fiz as mascaras dos inputs pra celular por que so lembrei agora e deu preguiça.

--Tecnologias e Bibliotecas usadas-
Laravel 8 - Jquery - Bootstrap - Ajax - DataTables - SweetAlert2


--------------------------------------------Documentação Do Sistema-----------------------------------------------

------Usuarios-------
* Assim que for registrado uma conta pela tela Register vai automaticamente ser um Administrador

* O Administrador poderá adicionar Tanto novos administradores como Vendendor/Tecnico, Todas informações no registro de um funcionario são obrigatorias

*O Administrador tem uma tela de funcionarios para poder editar ou desativar qualquer usuario. Detalhe, não é obrigatorio botar uma senha quando for editar um usuario, caso o administro altere alguma informação de um usuario, mas nao mudar a senha, a senha permanecera a mesma.

*O email é unico para os usuarios, sendo assim não se pode registrar um novo usuario ou editar um usuario para um email que já existe

*O Administrador tem uma tela de chamados para acompanhar os chamados, essa tela so mostra os usuarios ativos.

*O Adminstrador pode desativar um usuario, o unico impacto que tem é que o usuario não vai receber novas ocorrencias, porem ele ainda pode acessar os sistema.

------Chamados-------
*Os chamados são realizados na tela inicial no botão "Solicitar Suporte" não precisa estar logado para poder fazer um chamado, o nome e email não são obrigatorios, mas assunto e descrição sim.

*Adicionei os campos nome e email na abertura do chamado, porem eles não estão obrigatorios.

*Se não tiver nenhum usuario cadastro ou ativo como Vendendor/Tecnico, vai retornar uma tela de error informando que não tem tecnicos disponiveis.

*Se houver tecnico disponivel, o chamado irá pro usuario mais antigo com menos chamados, note que somente sera levado em conta chamados que não estão concluidos.

*Chamados abertos vem com o status padrão "Em Aberto"

*Quando um vendendor/tecnico estiver logado, ele so podera ter acesso a tela de chamados, assim que ele abrir um chamado, o chamado automaticamente ficará registrado como "Em andamento".

*Se um chamado com o Status tanto como "Em Aberto" e "Em andamento" Passarem de 1 dia ficaram como "Em atraso", não tem um status especifico, por que iria ser necessario uma job rodando no banco para atualizar os status, então o sistema faz um validação(Se tiver Em aberto ou Em andamento e tiver mais de 1 dia nesse status, é considerado como atrasado).

*Chamado é concluido quando o vendendor/tecnico abre o chamado e clicka em Concluir Ocorrencia



--------------------------------------------Configurar o Setup-----------------------------------------------
* Instalar o xamp ou algum servidor Apache.
* Instalar o composer
* Instalar o Laravel
* Instalar o NPM

*No caso do xamp, acessar a pasta xamp/htdocs e jogar o projeto la.
*Assim que fazer o donwload do projeto, procure uma pasta chamada .env.example, tire o example e deixe so o .env
*Crie um banco de dados, no caso do xamp, abra o painel do xamp, inicie o apache e o mysql, no mysql click em admin, irá levar pro navegador
*Na pasta .env em "DB_DATABASE" bote o nome do banco que voce criou
*Abra o terminal e digite o codigo "composer install", esse codigo vai instalar as dependencias do laravel
*Depois rode um "npm install", vai instalar as dependencias do node.js
* Rode um npm "run dev", para compilar.
* Depois rode um "php artisan migrate" para criar as tabelas no banco.
*Acesso o sistema ou pelo xamp ou rode o codigo "php artisan serve", vai te da uma url para acessar o sistema, provavelmente sera http://127.0.0.1:8000/.
*Vá em register e crie uma conta e siga os passos na documentação do sistema.
