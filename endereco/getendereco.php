<?php
require_once '../conexao.php';
require_once '../funcoes/funcoesenderecos.php';

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/endereco/getendereco.php",
 *     summary="Obter endereços",
 *     @OA\Parameter(
 *         name="country",
 *         in="query",
 *         required=false,
 *         description="País para filtrar os endereços",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         required=false,
 *         description="ID do endereço",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="enderecos",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Endereco")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Endereço não encontrado"
 *     )
 * )
 */

if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    try {
        if (isset($_GET['country'])) {
            $country = $_GET['country'];
            $enderecosUsuario = obterEnderecosPorPais($conn, $country);

            if (!empty($enderecosUsuario)) {
                http_response_code(200);
                echo json_encode(['enderecos' => $enderecosUsuario]);
            } else {
                http_response_code(200);
                echo json_encode(['enderecos' => []]);
            }
        } elseif (isset($_GET['id'])) {
            $endereco_id = $_GET['id'];
            $enderecoUsuario = obterEnderecoPorId($conn, $endereco_id);

            if (!empty($enderecoUsuario)) {
                http_response_code(200);
                echo json_encode($enderecoUsuario);
            } else {
                http_response_code(200);
                echo json_encode(['id' => null, 'erro' => 'Endereço não encontrado para o ID especificado']);
            }
        } else {
            http_response_code(200);
            echo json_encode(['erro' => 'Parâmetro não fornecido']);
        }

        $conn->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro interno do servidor: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
}
?>
