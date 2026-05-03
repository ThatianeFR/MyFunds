<?php
session_start();
require_once "funcoes.php";

$acessoPermitido = $_SESSION['autenticado'] ?? null;
if ($acessoPermitido === null) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['limpar'])) {
    unset($_SESSION['movimentacoes']);
    header("Location: historico.php");
    exit();
}

$movimentacoes = $_SESSION['movimentacoes'] ?? [];
$totalSaidasHistorico = somarSaidas($movimentacoes);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Histórico - MyFunds</title>
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
                <a href="index.php">Painel</a>
                <a href="historico.php" class="ativo">Histórico</a>
            </nav>
        </aside>

        <main class="conteudo">
            <div class="cabecalho-conteudo">
                <h1>Histórico Completo</h1>
                <p>Todas as suas movimentações organizadas.</p>
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

            <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                <a href="index.php" class="botao-voltar">← Voltar ao Painel</a>
                <a href="historico.php?limpar=1" class="botao-limpar" onclick="return confirm('Tem certeza que deseja limpar todos os dados?')">🗑️ Limpar Tudo</a>
            </div>

            <div class="ultimas-movimentacoes" style="padding: 0;">
                <div style="padding: 2rem; padding-bottom: 0;">
                    <h3>Todas as Movimentações</h3>
                </div>
                <div class="lista-movimentacoes" style="padding: 0 2rem 2rem;">
                    <?php if (empty($movimentacoes)): ?>
                        <p class="vazio">Nenhuma movimentação registrada ainda.</p>
                    <?php else: ?>
                        <?php foreach (array_reverse($movimentacoes) as $mov): ?>
                            <div class="item-movimentacao <?= $mov['tipo'] ?>">
                                <div class="detalhes-item">
                                    <span class="nome"><?= $mov['detalhes'] ?></span>
                                    <span class="data"><?= $mov['data'] ?? date('d/m/Y H:i') ?></span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 1.5rem;">
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; background: <?= $mov['tipo'] == 'entrada' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' ?>; color: <?= $mov['tipo'] == 'entrada' ? 'var(--cor-entrada)' : 'var(--cor-saida)' ?>;">
                                        <?= $mov['tipo'] == 'entrada' ? 'ENTRADA' : 'SAÍDA' ?>
                                    </span>
                                    <span class="valor <?= $mov['tipo'] ?>">
                                        <?= $mov['tipo'] == 'entrada' ? '+' : '-' ?> R$ <?= number_format($mov['valor'], 2, ',', '.') ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <?php include_once 'footer.php'; ?>
</body>
</html>
