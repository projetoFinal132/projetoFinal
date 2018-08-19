<?php
include_once("usuario.php");
    class Profissional extends Usuario{
        private $idProfissional;
        private $cpf;
        private $descricao;
        private $tipoServico;
        private $telefone;
        private $portifolio;
        private $senha;

        public function criaProfissional($cpfProfissional, $descricaoProfissional, $tipoServico, $telefoneProfissional, $portifolio, $emailUsuario, $tipoUsuario, $nomeUsuario, $senha, $nomeFotoPerfil, $diretorioFotoPerfil, $cidade){
            
            //if ($cpfProfissional && $descricaoProfissional && $tipoServico && $telefoneProfissional && $portifolio && $emailUsuario && $tipoUsuario && $nomeUsuario && $senhaUsuario && $nomeFotoPerfil && $diretorioFotoPerfil && $cidade && $bairro) {
                $this->cpf = $cpfProfissional;
                $this->descricao = $descricaoProfissional;
                $this->tipoServico = $tipoServico;
                $this->telefone = $telefoneProfissional;
                $this->portifolio = $portifolio;
                $this->emailUsuario = $emailUsuario;
                $this->senha = $senha;
                $this->tipoUsuario = $tipoUsuario;
                $this->nomeUsuario = $nomeUsuario;
                $this->nomeFotoPerfil = $nomeFotoPerfil;
                $this->diretorioFotoPerfil = $diretorioFotoPerfil;
                $this->cidade = $cidade;
            //}
        }
        public function getCpf(){
            return $this->cpf;
        }
        public function getDescricao(){
            return $this->descricao;
        }
        public function getTipoServico(){
            return $this->tipoServico;
        }
        public function getTelefone(){
            return $this->telefone;
        }
        public function getPortifolio(){
            return $this->portifolio;
        }
        public function getCidade(){
            return $this->cidade;
        }
        public function getidCidade(){
            return $this->cidade->getidCidade();
        }
        public function getBairro(){
            return $this->cidade->getBairro();
        }
        public function getIdBairro(){
            $cidade =  $this->cidade;
            $bairro = $cidade->getBairros();
            return $bairro;
        }
        public function getIdProfissional(){
            return $this->idProfissional;
        }
        public function getTudo(){
            $tudo = get_object_vars($this);
            //$tudo += $th;
            return $tudo;
        }
    }
?>