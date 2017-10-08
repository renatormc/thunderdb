# Thunder
PHP ORM 

ORM simples que pode ser utilizado em projetos PHP standalone. Basta importar para o projeto a pasta "Thunder" e começar a usar.

# Configurando banco de dados

A primeira coisa a ser feita é definir a conexão com o banco de dados, para isto abra o arquibo "config.php" dentro da pasta "Thunder" e defina a senha, usuário e tipod e conexão. A sintaxe é a mesma do PDO, a biblioteca utiliza PDO. 

# Criando models.
Para cada tabela no bano de dados é necessário haber um model correspondente.Para auxiliar no processo de criação dos models existe o arquivo "manage.php". Abra o terminal na pasta "Thunder" e digite o comando como abaixo:

php manage.php createmodel [Nome do model] [Nome da table no banco de dados]
  
ex:
php manage.php createmodel Usuario usuario

Com este procedimento um arquivo será criado na pasta "Models" contendo a estrutura inicial da classe já com todos os campos existentes na tabela referenciada. Porém os relacionamentos deverão ser definidos manualmente nos campos protected. 
  
# Queries

# Selecionar todos os usuários

$usuarios = Usuario::query()->all();

# Selecionar o usuário cujo nome seja "João"

$usuario = Usuario::query()->where("nome = 'João'")->first();

Se o valor estiver em uma variável:

$nome = "João";

$usuario = Usuario::query()->where("nome = ", $nome)->first();

Utilizando a função "And":

$usuario = Usuario::query()->where("nome = ", $nome)->and_("idade < 30")->first();

# Pegar um elemento pela chave primária

$usuário = Usuario::query()->get(1);

# Definir colections

Ao definir o modelo é possível definir relações "ManyToOne", "OneToMany" e "ManyToMany"

Por exemplo uma relação de usuário e grupo, que é do tipo "many to many". Para isso dentro da classe "Usuario" definimos um método público:

public function grupos(){
#
  return self::belongsToMany('Grupo');
}

Além disso é necessário declarar a relação na variável "colections" do tipo "pretected static":

 protected static $collections = ['grupos'=>'belongsToMany'];
 
 Depois para utilizar no código basta fazer o seguinte:
 
 //Para imprimir todos os grupos aos quais "João" pertence
 $usuario = Usuario::query()->where("nome = 'João'")->first();
 
 foreach($usuario->grupos() as $grupo){
 
  echo $grupo->nome;
 }
 
 Os tipos de telacionamento possíveis são:
 hasMany, belongsTo e belongsToMany
 
# Inserir
 
Para inserir valores novos deve ser feito o seguinte:
 
$usuario = new Usuario();
$usuario->nome = "José Maria";
$usuario->nickname = "josé";
$usuario->email = "joao@gmail.com";
$usuario->save();

Criar um grupo e adicionar dois novos usuários a ele:
$grupo = Grupo();

$usuario1 = new Usuario();
$usuario1->nome = "José Maria";
$usuario1->nickname = "josé";
$usuario1->email = "joao@gmail.com";

$usuario2 = new Usuario();
$usuario2->nome = "Maria Silva";
$usuario2->nickname = "mariasil";
$usuario2->email = "mariasilva@gmail.com";

$grupo->append('usuarios', usuario1);
$grupo->append('usuarios', usuario2);
$grupo->save();

# Deletar registros

Para deletar um registro deve-se proceder da seguinte forma:

Usuario::query()->where("nome = ", $nome)->delete();

para deletar todos os usuários com idade abaixo de 30 anos:
Usuario::query()->where("idade < 30")->delete();
