<?php
class Pessoa

{
    private $nome;
    private $nascimento;
    private $peso;
    private $altura;
    private $cpf;
    private $imc;
    private $idade;
    private $statuspeso;

    public function Pessoa ($nome, $nascimento, $cpf, $altura, $peso) 
    {
        $this->nome = $nome;
        $this->validaCPF ($cpf);
        $this->calculaImc ($peso, $altura);
        $this->calculaIdade ($nascimento);


    }
    public function calculaImc ($peso, $altura)
        {
            $this->peso = $peso;
            $this->altura = $altura;
            $imc = $peso/($altura*$altura);
            $this->imc = $imc;

            if ($imc < 18.5)
            {
                $this->statuspeso = 'Magro';
            }
            elseif ($imc >=18.5 and $imc <25)
            {
                $this->statuspeso = 'Peso Ideal';
            }
            elseif ($imc > 25 and $imc < 30)
            {
                $this->statuspeso = 'Acima do Peso';
            }
            elseif ($imc >= 30)
            {
                $this->statuspeso = 'Obesidade';
            }
        }

    public function calculaIdade ($nascimento)
    {
        $this->nascimento = $nascimento;

        list($dia, $mes, $ano) = explode('/', $nascimento);

        $hoje = mktime (0,0,0, date ('m'), date ('d'), date('y'));
        $datanasc = mktime (0, 0, 0, $mes, $dia, $ano);
        $idade = floor ((((($hoje - $datanasc) / 60) / 60) / 24) / 365.25);
        $this->idade = $idade;
    }

    public function validaCPF ($cpf)
    {
        $this->cpf = $cpf;

        //Elimina os pontos e traços
        $cpf = preg_replace('/[^0-9]/','',$cpf);
   
        // 1º Passo de validação - Validando o primeiro dígito
        $digitoA = 0;
        for ($n = 0, $d = 10; $n <= 8; $n++, $d--)
        {
            $digitoA += $cpf[$n]*$d;
        }

        $somaA = (($digitoA%11) < 2) ? 0 : 11-($digitoA%11);
        
        // 2º Passo de validação - Validando o segundo dígito
        $digitoB = 0;
        for ($n = 0, $d = 11; $n <= 9; $n++, $d--)
        {
        // Checa se os números foram repetidos
            if (str_repeat ($n, 11) == $cpf)
            {
                return false;
            }    
            $digitoB += $cpf[$n]*$d;
        }

        $somaB = (($digitoB%11) < 2) ? 0 : 11-($digitoB%11);

        // 3º Passo de validação - Retornando validade da operação
        if ($somaA != $cpf[9] or $somaB != $cpf[10])
        {
            $this->cpf = 'CPF inválido';
        }
        else
        {
            return true;
        }
    }
}