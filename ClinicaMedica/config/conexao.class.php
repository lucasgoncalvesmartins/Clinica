<?php
/*
banco de dados crud em mysql
CREATE TABLE `produto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
)
*/

class conexao
{
    private $db_host = 'localhost'; // servidor
    private $db_user = 'root'; // usuário do banco
    private $db_pass = ''; // senha do usuário do banco
    private $db_name = 'clinica'; // nome do banco

    private $con = null; // Conexão com o banco de dados

    // Estabelece a conexão
    public function connect()
    {
        if ($this->con === null) {
            // Cria a conexão com mysqli
            $this->con = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

            // Verifica se houve erro na conexão
            if ($this->con->connect_error) {
                die("Falha na conexão com o banco de dados: " . $this->con->connect_error);
            }

            return true;
        }
        return false;
    }

    // Fecha a conexão
    public function disconnect()
    {
        if ($this->con !== null) {
            $this->con->close();
            $this->con = null;
            return true;
        }
        return false;
    }

    // Método para realizar consultas
    public function query($sql)
    {
        return $this->con->query($sql);
    }

    // Método para preparar uma consulta com parâmetros
    public function prepare($sql)
    {
        return $this->con->prepare($sql);
    }

    // Método para obter a conexão ativa
    public function getConnection()
    {
        return $this->con;
    }
}

?>