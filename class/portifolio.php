<?php
    class ImgPortifolio{
        public $diretorioFoto;
        public $nomeFoto;

        public function criaPortifolio($diretorioFoto, $nomeFoto){
            if ($diretorioFoto && $nomeFoto) {
               $this->diretorioFoto = $diretorioFoto;
               $this->nomeFoto = $nomeFoto;
            }
        }

        public function getDiretorioFoto(){
            return $this->diretorioFoto;
        }
        public function getNomeFoto(){
            return $this->nomeFoto;
        }
        public function setDiretorioFoto($diretorioFoto){
            $this->diretorioFoto = $diretorioFoto;
        }
        public function setNomeFoto($nomeFoto){
            $this->nomeFoto = $nomeFoto;
        }
    }

    
?>