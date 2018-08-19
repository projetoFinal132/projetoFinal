<?php

    class Servico{
        private $idServico;
        private $nomeServico;


        public function criaServico($idServico, $nomeServico){
            $this->idServico = $idServico;
            $this->nomeServico = $nomeServico;
        }

        public function getIdServico(){
            return $this->idServico;
        }
        public function getNomeServico(){
            return $this->nomeServico;
        }
        

    }

?>