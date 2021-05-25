<?php


class pratos
{
    private String $categoria;
    private String $prato;


    function incioJogo(){
        $_SESSION['pratos'] = array();
        $file = fopen('dados.csv', 'r');
        while (($line = fgetcsv($file)) !== false)
        {
            if(is_array($line)) {
                $_SESSION['pratos'][] = $line;
            }
        }
        fclose($file);
    }

    function loopJogo(){
        $this->categoria = '';
        $this->prato = '';
        if (count($_SESSION['pratos'])>0){
            $prato = current($_SESSION['pratos']);
            $this->categoria = $prato[0];
            $this->prato = $prato[1];
            unset($_SESSION['pratos'][array_key_first($_SESSION['pratos'])]);
        }
    }

    function inserePrato(){
        $file = fopen('dados.csv','a');
        fputcsv($file,array($this->prato,$this->categoria));
        fclose($file);

    }



    /**
     * @return String
     */
    public function getCategoria(): string
    {
        return $this->categoria;
    }

    /**
     * @param String $categoria
     */
    public function setCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
    }

    /**
     * @return String
     */
    public function getPrato(): string
    {
        return $this->prato;
    }

    /**
     * @param String $prato
     */
    public function setPrato(string $prato): void
    {
        $this->prato = $prato;
    }
}