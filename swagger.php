<?php
require 'vendor/autoload.php';

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API de Endereços e Usuários",
 *     version="1.0.0",
 *     description="Esta é a documentação da API de Endereços e Usuários."
 * )
 */

/**
 * @OA\Server(
 *     url="http://localhost/liven",
 *     description="Servidor Local"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Endereco",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="usuario_id", type="integer"),
 *     @OA\Property(property="pais", type="string"),
 *     @OA\Property(property="endereco", type="string")
 * )
 */

$openapi = \OpenApi\Generator::scan([__DIR__ . '/endereco', __DIR__ . '/usuario']);

header('Content-Type: application/json');
echo $openapi->toJson();
