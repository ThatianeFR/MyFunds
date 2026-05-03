<?php

function calcularBalancoGeral($listaMovimentacoes) {
    $balancoTotal = 0;
    if ($listaMovimentacoes === null) {
        return $balancoTotal;
    }
    foreach ($listaMovimentacoes as $movimentacao) {
        $valorMov = $movimentacao['valor'];
        $tipoMov = $movimentacao['tipo'];
        switch ($tipoMov) {
            case 'entrada':
                $balancoTotal = $balancoTotal + $valorMov;
                break;
            case 'saida': 
                $balancoTotal = $balancoTotal - $valorMov;
                break;
        }
    }
    return $balancoTotal;
} 

function somarEntradas($listaMovimentacoes) {
    $totalEntrada = 0;
    if ($listaMovimentacoes != null) {
        foreach ($listaMovimentacoes as $movimentacao) {
            if ($movimentacao['tipo'] == 'entrada') {
                $totalEntrada = $totalEntrada + $movimentacao['valor'];
            }
        }
    }
    return $totalEntrada;
}

function somarSaidas($listaMovimentacoes) {
    $totalSaida = 0;
    if ($listaMovimentacoes != null) {
        foreach ($listaMovimentacoes as $movimentacao) {
            if ($movimentacao['tipo'] == 'saida') {
                $totalSaida = $totalSaida + $movimentacao['valor'];
            }
        }
    }
    return $totalSaida;
}

function calcularPercentualSaida($valorSaida, $totalSaidas) {
    if ($totalSaidas == 0) {
        return 0;
    }
    $percentual = ($valorSaida / $totalSaidas) * 100;
    return round($percentual, 2);
}

?>
