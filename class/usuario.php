<?php 
    class Usuario {
        protected $emailUsuario;
        protected $tipoUsuario;
        protected $nomeUsuario;
        protected $senhaUsuario;
        protected $nomeFotoPerfil;
        protected $diretorioFotoPerfil;
        protected $cidade;
        protected $bairro;

        public function criaUsuario($emailUsuario, $tipoUsuario, $nomeUsuario, $senha, $nomeFotoPerfil, $diretorioFotoPerfil, $cidade, $bairro){
            if ($emailUsuario && $tipoUsuario && $nomeUsuario && $senha  && $nomeFotoPerfil && $diretorioFotoPerfil && $cidade) {
                $this->emailUsuario = $emailUsuario;
                $this->tipoUsuario = $tipoUsuario;
                $this->nomeUsuario = $nomeUsuario;
                $this->nomeFotoPerfil = $nomeFotoPerfil;
                $this->diretorioFotoPerfil = $diretorioFotoPerfil;
                $this->cidade = $cidade;
                $this->bairro = $bairro;
                $this->senhaUsuario = $senha;
            }
        }
        public function getNomeUsuario(){
            return $this->nomeUsuario;
        }
        public function getEmailUsuario(){
            return $this->emailUsuario;
        }
        public function getSenhaUsuario(){
            return $this->senhaUsuario;
        }
        public function getTipoUsuario(){
            return $this->tipoUsuario;
        }
        public function getNomeFotoPerfil(){
            return $this->nomeFotoPerfil;
        }
        public function getDiretorioFotoPerfil(){
            return $this->diretorioFotoPerfil;
        }
        public function getCidade(){
            return $this->cidade;
        }
        public function getBairro(){
            return $this->bairro;
        }
        public function setNomeFotoPerfil($novoNome){
            $this->nomeFotoPerfil = $novoNome;
        }
        
        public function getTudo(){
            $tudo = get_object_vars($this);
            return $tudo;
        }
    }
?>