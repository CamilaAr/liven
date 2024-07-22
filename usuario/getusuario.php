<?php
require_once '../conexao.php';
require_once '../funcoes/funcoesenderecos.php';

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/usuario/getusuario.php",
 *     summary="Obter endereços de um usuário",
 *     @OA\Parameter(
 *         name="usuario_id",
 *         in="query",
 *         required=true,
 *         description="ID do usuário",
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
 *         description="Endereços não encontrados"
 *     )
 * )
 */

if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    try {
        if (isset($_GET['usuario_id'])) {
            $usuario_id = $_GET['usuario_id'];
            $enderecosUsuario = obterEnderecosPorUsuarioId($conn, $usuario_id);

            if (!empty($enderecosUsuario)) {
                http_response_code(200);
                echo json_encode(['enderecos' => $enderecosUsuario]);
            } else {
                http_response_code(200);
                echo json_encode(['enderecos' => []]);
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
