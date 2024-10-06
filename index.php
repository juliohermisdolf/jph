<?php
session_start();
include('includes/auth.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 text-white">
        <ul class="flex space-x-4">
            <li><a href="index.php" class="hover:underline">Home</a></li>
            
            <!-- Cadastro Dropdown -->
            <li class="relative">
                <a href="#" class="hover:underline">Cadastro</a>
                <ul class="absolute left-0 hidden bg-white text-black p-2 shadow-lg">
                    <li><a href="pages/cadastro/empresa.php" class="block px-4 py-2 hover:bg-gray-200">Empresa</a></li>
                    <li><a href="pages/cadastro/clientes.php" class="block px-4 py-2 hover:bg-gray-200">Clientes</a></li>
                    <li><a href="pages/cadastro/contratos.php" class="block px-4 py-2 hover:bg-gray-200">Contratos</a></li>
                    <li><a href="pages/cadastro/funcionarios.php" class="block px-4 py-2 hover:bg-gray-200">Funcionários</a></li>
                </ul>
            </li>

            <!-- Processos Dropdown -->
            <li class="relative">
                <a href="#" class="hover:underline">Processos</a>
                <ul class="absolute left-0 hidden bg-white text-black p-2 shadow-lg">
                    <li><a href="pages/processos/automatico.php" class="block px-4 py-2 hover:bg-gray-200">Processo Automático</a></li>
                    <li><a href="pages/processos/fisico.php" class="block px-4 py-2 hover:bg-gray-200">Processo Físico</a></li>
                    <li><a href="pages/processos/listar_processos.php" class="block px-4 py-2 hover:bg-gray-200">Listar Processos</a></li>
                </ul>
            </li>

            <!-- Financeiro Dropdown -->
            <li class="relative">
                <a href="#" class="hover:underline">Financeiro</a>
                <ul class="absolute left-0 hidden bg-white text-black p-2 shadow-lg">

                    <!-- Contas a Receber -->
                    <li class="relative">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Contas a Receber</a>
                        <ul class="absolute left-full top-0 hidden bg-white text-black p-2 shadow-lg">
                            <li><a href="pages/financeiro/receber_fatura.php" class="block px-4 py-2 hover:bg-gray-200">Recebimento de Fatura</a></li>
                            <li><a href="pages/financeiro/editar_fatura.php" class="block px-4 py-2 hover:bg-gray-200">Alteração de Fatura</a></li>
                            <li><a href="pages/financeiro/listar_contas_inativas.php" class="block px-4 py-2 hover:bg-gray-200">Contas Inativas</a></li>
                            <li><a href="pages/financeiro/listar_faturas_recebidas.php" class="block px-4 py-2 hover:bg-gray-200">Faturas Recebidas</a></li>
                            <li><a href="pages/financeiro/excluir_fatura.php" class="block px-4 py-2 hover:bg-gray-200">Exclusão de Fatura</a></li>
                        </ul>
                    </li>

                    <!-- Contas a Pagar -->
                    <li class="relative">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Contas a Pagar</a>
                        <ul class="absolute left-full top-0 hidden bg-white text-black p-2 shadow-lg">
                            <li><a href="pages/financeiro/pagar_conta.php" class="block px-4 py-2 hover:bg-gray-200">Pagamento de Conta</a></li>
                            <li><a href="pages/financeiro/editar_conta.php" class="block px-4 py-2 hover:bg-gray-200">Alteração de Conta</a></li>
                            <li><a href="pages/financeiro/listar_contas_pagas.php" class="block px-4 py-2 hover:bg-gray-200">Contas Pagas</a></li>
                            <li><a href="pages/financeiro/excluir_conta.php" class="block px-4 py-2 hover:bg-gray-200">Exclusão de Conta</a></li>
                        </ul>
                    </li>

                    <!-- Despesas -->
                    <li class="relative">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Despesas</a>
                        <ul class="absolute left-full top-0 hidden bg-white text-black p-2 shadow-lg">
                            <li><a href="pages/financeiro/adicionar_despesa.php" class="block px-4 py-2 hover:bg-gray-200">Lançamento de Despesas</a></li>
                            <li><a href="pages/financeiro/estornar_despesa.php" class="block px-4 py-2 hover:bg-gray-200">Estorno de Despesas</a></li>
                        </ul>
                    </li>

                    <li><a href="pages/financeiro/listar_cheques_clientes.php" class="block px-4 py-2 hover:bg-gray-200">Cheques dos Clientes</a></li>
                    <li><a href="pages/financeiro/listar_cheques_empresa.php" class="block px-4 py-2 hover:bg-gray-200">Cheques da Empresa</a></li>
                    <li><a href="pages/financeiro/fluxo_caixa.php" class="block px-4 py-2 hover:bg-gray-200">Fluxo de Caixa</a></li>

                    <!-- Recibos Avulsos -->
                    <li class="relative">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Recibos Avulsos</a>
                        <ul class="absolute left-full top-0 hidden bg-white text-black p-2 shadow-lg">
                            <li><a href="pages/financeiro/gerar_recibo.php" class="block px-4 py-2 hover:bg-gray-200">Gerar Recibo</a></li>
                            <li><a href="pages/financeiro/listar_recibos.php" class="block px-4 py-2 hover:bg-gray-200">Relatório de Recibos</a></li>
                            <li><a href="pages/financeiro/imprimir_recibos.php" class="block px-4 py-2 hover:bg-gray-200">Imprimir em Lote</a></li>
                        </ul>
                    </li>

                    <!-- Meus Créditos -->
                    <li class="relative">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Meus Créditos</a>
                        <ul class="absolute left-full top-0 hidden bg-white text-black p-2 shadow-lg">
                            <li><a href="pages/financeiro/meus_creditos.php" class="block px-4 py-2 hover:bg-gray-200">Créditos Disponíveis</a></li>
                            <li><a href="pages/financeiro/extrato_debitos.php" class="block px-4 py-2 hover:bg-gray-200">Extrato de Débitos</a></li>
                        </ul>
                    </li>

                    <li><a href="pages/financeiro/resumo_financeiro.php" class="block px-4 py-2 hover:bg-gray-200">Resumo Financeiro</a></li>
                    <li><a href="pages/financeiro/movimento_caixa.php" class="block px-4 py-2 hover:bg-gray-200">Movimento do Caixa</a></li>
                </ul>
            </li>

            <!-- Honorários Dropdown -->
            <li class="relative">
                <a href="#" class="hover:underline">Honorários</a>
                <ul class="absolute left-0 hidden bg-white text-black p-2 shadow-lg">
                    <li><a href="pages/honorarios/orcamento.php" class="block px-4 py-2 hover:bg-gray-200">Orçamento</a></li>
                    <li><a href="pages/honorarios/estorno.php" class="block px-4 py-2 hover:bg-gray-200">Estorno de Honorários</a></li>
                    <li><a href="pages/honorarios/relatorio_honorarios.php" class="block px-4 py-2 hover:bg-gray-200">Relatório de Honorários</a></li>
                </ul>
            </li>

            <!-- Consultas -->
            <li><a href="pages/consultas.php" class="hover:underline">Consultas</a></li>

            <!-- Logout -->
            <li><a href="logout.php" class="hover:underline">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-4">Painel Administrativo</h1>
        <p>Bem-vindo ao sistema de advocacia! Use o menu acima para navegar pelas funcionalidades.</p>
    </div>

    <script>
        // Código JavaScript para exibir e ocultar os submenus
        document.querySelectorAll('nav li.relative').forEach(function (menu) {
            menu.addEventListener('mouseenter', function () {
                menu.querySelector('ul').classList.remove('hidden');
            });
            menu.addEventListener('mouseleave', function () {
                menu.querySelector('ul').classList.add('hidden');
            });
        });
    </script>

</body>
</html>
