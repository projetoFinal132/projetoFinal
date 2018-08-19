<?php
    class Bairro{
        public $idBairro;
        public $nomeBairro;
        public $fkBairroCidade;
        public function criaBairro($idBairro, $nomeBairro, $fkBairroCidade){
            $this->idBairro = $idBairro;
            $this->nomeBairro = $nomeBairro;
            $this->fkBairroCidade = $fkBairroCidade;
        }
        public function getNomeBairro(){
            return $this->nomeBairro;
        }
        public function getIdBairro(){
            return $this->idBairro;
        }
        public function getFkBairroCidade(){
            return $this->fkBairroCidade;
        }
    }

?>