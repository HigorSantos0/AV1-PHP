<?php

function criarPergunta($pergunta, $tipo_resposta, $respostas)
{
    $perguntaData = array(
        'pergunta' => $pergunta,
        'tipo_resposta' => $tipo_resposta,
        'respostas' => $respostas
    );

 
    $perguntas = lerPerguntas();
    $perguntas[] = $perguntaData;
    salvarPerguntas($perguntas);

    echo "Sua Pergunta Foi Criada!";
}

function alterarPergunta($id_pergunta, $nova_pergunta, $novas_respostas)
{
    $perguntas = lerPerguntas();

    if (isset($perguntas[$id_pergunta])) {
        if (!empty($nova_pergunta)) {
            $perguntas[$id_pergunta]['pergunta'] = $nova_pergunta;
        }

        if (!empty($novas_respostas)) {
            $perguntas[$id_pergunta]['respostas'] = $novas_respostas;
        }

        salvarPerguntas($perguntas);

        echo "Alteração feita!";
    } else {
        echo "ID inválido!";
    }
}

function listarPerguntas()
{
    $perguntas = lerPerguntas();

    if (empty($perguntas)) {
        echo "Não existem perguntas Cadastradas.";
    } else {
        foreach ($perguntas as $id => $pergunta) {
            echo "ID: " . $id . "<br>";
            echo "Pergunta: " . $pergunta['pergunta'] . "<br>";
            echo "Tipo de Resposta: " . $pergunta['tipo_resposta'] . "<br>";
            echo "Respostas: " . $pergunta['respostas'] . "<br><br>";
        }
    }
}

function listarPergunta($id_pergunta)
{
    $perguntas = lerPerguntas();

    if (isset($perguntas[$id_pergunta])) {
        $pergunta = $perguntas[$id_pergunta];

        echo "ID: " . $id_pergunta . "<br>";
        echo "Pergunta: " . $pergunta['pergunta'] . "<br>";
        echo "Tipo de Resposta: " . $pergunta['tipo_resposta'] . "<br>";
        echo "Respostas: " . $pergunta['respostas'] . "<br>";
    } else {
        echo "ID inválido!";
    }
}

function excluirPergunta($id_pergunta)
{
$perguntas = lerPerguntas();

if (isset($perguntas[$id_pergunta])) {
    unset($perguntas[$id_pergunta]);
    salvarPerguntas($perguntas);

    echo "Exclusão feita!";
} else {
    echo "ID inválido!";
}
}

function lerPerguntas()
{
$perguntas = array();

if (file_exists('lista.txt')) {
    $perguntas = unserialize(file_get_contents('lista.txt'));
}

return $perguntas;
}

function salvarPerguntas($perguntas)
{
file_put_contents('lista.txt', serialize($perguntas));
}

if (isset($_POST['acao'])) {
$acao = $_POST['acao'];

switch ($acao) {
    case 'criar':
        if (isset($_POST['pergunta']) && isset($_POST['tipo_resposta']) && isset($_POST['respostas'])) {
            $pergunta = $_POST['pergunta'];
            $tipo_resposta = $_POST['tipo_resposta'];
            $respostas = $_POST['respostas'];

            criarPergunta($pergunta, $tipo_resposta, $respostas);
        }
        break;
    case 'alterar':
        if (isset($_POST['id_pergunta']) && isset($_POST['nova_pergunta']) && isset($_POST['novas_respostas'])) {
            $id_pergunta = $_POST['id_pergunta'];
            $nova_pergunta = $_POST['nova_pergunta'];
            $novas_respostas = $_POST['novas_respostas'];

            alterarPergunta($id_pergunta, $nova_pergunta, $novas_respostas);
        }
        break;
    case 'listar':
        listarPerguntas();
        break;
    case 'listar_uma':
        if (isset($_POST['id_pergunta_listar'])) {
            $id_pergunta_listar = $_POST['id_pergunta_listar'];

            listarPergunta($id_pergunta_listar);
        }
        break;
    case 'excluir':
        if (isset($_POST['id_pergunta_excluir'])) {
            $id_pergunta_excluir = $_POST['id_pergunta_excluir'];

            excluirPergunta($id_pergunta_excluir);
        }
        break;
    default:
        echo "Ação inválida!";
        break;
}
}

