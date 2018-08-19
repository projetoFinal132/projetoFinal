<?php
    class Cidade{
        public $idCidade;
        public $nomeCidade;
        public $bairros;


        public function criaCidade($idCidade, $bairros, $nomeCidade = "nada"){
            $this->idCidade = $idCidade;
            $this->nomeCidade = $nomeCidade;
            $this->bairros = $bairros;
        }

        public function getidCidade(){
            return $this->idCidade;
        }
        public function getBairros(){
            return $this->bairros;
        }
        public function getTudoCidade(){
            return get_object_vars($this);
        }
        

    }

    

?>