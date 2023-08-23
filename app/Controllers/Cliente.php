<?php

namespace App\Controllers;


class Cliente extends BaseController
{
    public function enviarEmail(){
        $db = \Config\Database::connect();
        $hoje = date('Y-m-d');
        $proximaSemana = date('Y-m-d', strtotime('+7 days'));

        $clientesAniversariantes = $db->query("
            SELECT * FROM clientes
            WHERE DATE_FORMAT(data_nascimento, '%m-%d') 
            BETWEEN DATE_FORMAT('$hoje', '%m-%d') AND DATE_FORMAT('$proximaSemana', '%m-%d')
        ")->getResultArray();

        if (empty($clientesAniversariantes)) {
            $msg['msg'] = "Não há aniversariantes nos próximos 7 dias.";

            return view ('listaClientes', $msg);
        } else {
            $emailsParaParabens = [];

            $email = \Config\Services::email();

            foreach ($clientesAniversariantes as $cliente) {
                $nome = $cliente['nome'];
                $dataNascimento = date('d/m', strtotime($cliente['data_nascimento']));
                $emailCliente = $cliente['email'];
            
                $emailsParaParabens[] = $emailCliente;
            
                $email->setFrom('pedrohfernandes95@gmail.com', 'Pedro Henrique Dos Santos');
                $email->setTo($emailCliente);
                $email->setSubject('Feliz Aniversário!');
            
                $mensagem = "Olá $nome,\n\nTenha um feliz aniversário cheio de sorrisos e gargalhadas, repleto de paz, amor e muita alegria.
                Parabéns por mais um ano de vida nessa data de $dataNascimento!";
                $email->setMessage($mensagem);
            
                $email->send();
            }

            $query = $db->query('SELECT * FROM clientes');
            $result = $query->getResult();
            $data['result'] = $result;
            return view('listaClientes', [
                'result' => $result,
                'emailsParaParabens' => $emailsParaParabens,
                'data' => $data
            ]);
        }
    }
    
    public function listaClientes(){
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM clientes');
        $result = $query->getResult();
        $data['result'] = $result;
        return view ('listaClientes', $data);
    }
    
    public function cadastro(){
        return  view ('Cadastro');
    }

    public function cadastrarCliente(){

        $db = \Config\Database::connect();
        $nome = $this->request->getPost('nome');
        $email = $this->request->getPost('email');
        $dataNascimento = $this->request->getPost('data_nascimento');

        $emailExiste = $db->table('clientes')->where('email', $email)->countAllResults() > 0;

        if ($emailExiste) {
            $msg['msg'] = "Já existe cliente cadastrado com esse email!";

            return view ('Cadastro', $msg);
        }

        $data = [
            'nome' => $nome,
            'email' => $email,
            'data_nascimento' => $dataNascimento,
        ];

        $db->table('clientes')->insert($data);

        $msg['msg'] = "Cliente inserido com sucesso!";

        return view ('Cadastro', $msg);
    }

}

