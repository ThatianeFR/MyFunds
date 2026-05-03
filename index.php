

<?php
session_start();
require_once "funcoes.php";

$acessoPermitido = $_SESSION['autenticado'] ?? null;
if ($acessoPermitido === null) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $detalhes = $_POST['detalhes'] ?? null;
    $valorMov = $_POST['valorMov'] ?? 0;
    $categoria = $_POST['categoria'] ?? null;

    if (!is_null($detalhes) && $detalhes != '' && $valorMov > 0 && !is_null($valorMov) && !is_null($categoria)) {
        $_SESSION['movimentacoes'][] = [
            'detalhes' => $detalhes,
            'valor' => $valorMov,
            'tipo' => $categoria,
            'data' => date('d/m/Y H:i')
        ];
    }
}

$movimentacoes = $_SESSION['movimentacoes'] ?? [];
$ultimasMovimentacoes = array_slice($movimentacoes, -5);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Painel - MyFunds</title>
</head>
<body>
    <?php include_once 'header.php'; ?>

    <div class="container-principal">
        <aside class="barra-lateral">
            <div class="usuario-info">
                <div class="avatar"><?= substr($_SESSION['nomeUsuario'], 0, 1) ?></div>
                <h3><?= $_SESSION['nomeUsuario'] ?></h3>
                <p>@<?= $_SESSION['usuario'] ?></p>
            </div>

            <nav class="menu-lateral">
                <a href="index.php" class="ativo">Painel</a>
                <a href="historico.php">Histórico</a>
            </nav>
        </aside>

        <main class="conteudo">
            <div class="cabecalho-conteudo">
                <h1>Olá, <?= $_SESSION['nomeUsuario'] ?>!</h1>
            </div>

            <div class="cards-resumo">
                <div class="card card-entrada">
                    <div class="icone">💸</div>
                    <div class="info-card">
                        <span>Total Entradas</span>
                        <h2>R$ <?= number_format(somarEntradas($movimentacoes), 2, ',', '.') ?></h2>
                    </div>
                </div>

                <div class="card card-saida">
                    <div class="icone">💳</div>
                    <div class="info-card">
                        <span>Total Saídas</span>
                        <h2>R$ <?= number_format(somarSaidas($movimentacoes), 2, ',', '.') ?></h2>
                    </div>
                </div>

                <div class="card card-balanco">
                    <div class="icone">💰</div>
                    <div class="info-card">
                        <span>Balanço Geral</span>
                        <h2>R$ <?= number_format(calcularBalancoGeral($movimentacoes), 2, ',', '.') ?></h2>
                    </div>
                </div>
            </div>

            <div class="area-principal">
                <div class="formulario-nova">
                    <h3>Nova Movimentação</h3>
                    <form action="index.php" method="POST">
                        <div class="campo">
                            <label>Detalhes</label>
                            <input type="text" name="detalhes" placeholder="Ex: Salário, Aluguel..." required>
                        </div>
                        <div class="campo">
                            <label>Valor (R$)</label>
                            <input type="number" step="0.01" name="valorMov" placeholder="0,00" required>
                        </div>
                        <div class="campo">
                            <label>Tipo</label>
                            <select name="categoria" required>
                                <option value="">Selecione</option>
                                <option value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                        </div>
                        <button type="submit">Adicionar</button>
                    </form>
                </div>

                <div class="ultimas-movimentacoes">
                    <h3>Últimas Movimentações</h3>
                    <div class="lista-movimentacoes">
                        <?php if (empty($ultimasMovimentacoes)): ?>
                            <p class="vazio">Nenhuma movimentação registrada ainda.</p>
                        <?php else: ?>
                            <?php foreach (array_reverse($ultimasMovimentacoes) as $mov): ?>
                                <div class="item-movimentacao <?= $mov['tipo'] ?>">
                                    <div class="detalhes-item">
                                        <span class="nome"><?= $mov['detalhes'] ?></span>
                                        <span class="data"><?= $mov['data'] ?? date('d/m/Y H:i') ?></span>
                                    </div>
                                    <span class="valor <?= $mov['tipo'] ?>">
                                        <?= $mov['tipo'] == 'entrada' ? '+' : '-' ?> R$ <?= number_format($mov['valor'], 2, ',', '.') ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <a href="historico.php" class="ver-todas">Ver todas →</a>
                </div>
            </div>
        </main>
    </div>

    <?php include_once 'footer.php'; ?>
</body>
</html>
