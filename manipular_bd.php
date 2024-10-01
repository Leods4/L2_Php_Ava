<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "";

    if ($_POST['action'] === 'add') {
        $cliente = $conn->real_escape_string($_POST['cliente']);
        $veiculo = $conn->real_escape_string($_POST['veiculo']);
        $valor = $conn->real_escape_string($_POST['valor']);
        $periodo = $conn->real_escape_string($_POST['periodo']);

        $sql = "INSERT INTO locacoes (Cliente, Veiculo, Valor_da_Locacao, Periodo_de_Locacao) VALUES ('$cliente', '$veiculo', '$valor', '$periodo')";
        if ($conn->query($sql) === TRUE) {
            echo '<div style="text-align: center;"><p class="success">Cliente Adicionado</p></div>';
        } else {
            echo '<div style="text-align: center;"><p class="error">Erro</p></div>';
        }
        exit;
    }

    if ($_POST['action'] === 'delete') {
        $clienteToDelete = $conn->real_escape_string($_POST['cliente_delete']);
        $sql = "DELETE FROM locacoes WHERE Cliente = '$clienteToDelete'";
        if ($conn->query($sql) === TRUE) {
            echo '<div style="text-align: center;"><p class="success">Cliente Excluído</p></div>';
        } else {
            echo '<div style="text-align: center;"><p class="error">Erro</p></div>';
        }
        exit;
    }
}

if (isset($_GET['show_records']) && $_GET['show_records'] == 'true') {
    echo '<!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Mostrar Locações</title>
    </head>
    <body>';

    $sql = "SELECT * FROM locacoes";
    $result = $conn->query($sql);

    $totalValor = 0;

    echo "<div class='container'>";
    echo "<h4>Lista de Locações</h4>";
    echo "<hr class='divider'>";

    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Veiculo</th>
                        <th>Valor da Locacao</th>
                        <th>Periodo de Locacao</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["ID"] . "</td>
                    <td>" . $row["Cliente"] . "</td>
                    <td>" . $row["Veiculo"] . "</td>
                    <td>R$ " . number_format($row["Valor_da_Locacao"], 2, ',', '.') . "</td>
                    <td>" . $row["Periodo_de_Locacao"] . "</td>
                  </tr>";
            $totalValor += $row["Valor_da_Locacao"];
        }
        echo "</tbody></table>";
        echo "<hr class='divider'>";
        echo "<h4 class='total'>Valor Total: R$ " . number_format($totalValor, 2, ',', '.') . "</h4>";
    } else {
        echo "<h4>0 resultados</h4>";
    }

    echo "</div></body></html>";
}

$conn->close();
?>
