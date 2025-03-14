<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

final class DocumentationController
{
    public function index(): void
    {
        header('Content-Type: text/html; charset=utf-8');
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Documentación de la API</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: #f5f5f5;
                    margin: 0;
                    padding: 20px;
                }
                .container {
                    max-width: 800px;
                    margin: 0 auto;
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                }
                h1 {
                    color: #333;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid #ddd;
                }
                th, td {
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background: #f2f2f2;
                }
                code {
                    background: #eee;
                    padding: 2px 4px;
                    border-radius: 4px;
                    font-size: 0.9em;
                }
                .back-link {
                    margin-top: 20px;
                    display: block;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Documentación de la API</h1>
                <p>A continuación se detallan los endpoints disponibles:</p>
                <table>
                    <thead>
                        <tr>
                            <th>Método</th>
                            <th>Ruta</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>POST</td>
                            <td>/register</td>
                            <td>
                                Registrar un nuevo usuario. Se requiere enviar un JSON con los campos <code>name</code>, <code>email</code> y <code>password</code>.
                            </td>
                        </tr>
                        <!-- Puedes agregar más endpoints aquí -->
                    </tbody>
                </table>
                <a class="back-link" href="/">Volver a la página de bienvenida</a>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}
