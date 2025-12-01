<?php include '../includes/headerCadastrado.php'; ?>

<!-- Seção do Catálogo -->
<section class="food_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Nossos Serviços Capilares</h2>
            <p class="text-muted">Serviços exclusivos para clientes cadastrados</p>
        </div>

        <!-- Filtros por Categoria -->
        <ul class="filters_menu">
            <li class="active" data-filter="*">Todos os Serviços</li>
    <li data-filter=".penteados">Penteados</li>
            <li data-filter=".corte">Cortes</li>
            <li data-filter=".combos">Combos</li>
            <li data-filter=".tratamentos">Tratamentos</li>
            <li data-filter=".progressiva">Progressiva</li>
            <li data-filter=".coloracao">Coloração</li>
        </ul>

        <div class="filters-content">
            <div class="row grid">
                <?php
                include '../includes/catalogo_dinamico.php';
                $procedimentos = getProcedimentosPorCategoria($conn);
                
                if (empty($procedimentos)) {
                    echo '<div class="col-12 text-center">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> 
                                Em breve teremos novidades! Nossos serviços estão sendo preparados.
                            </div>
                          </div>';
                } else {
                    foreach ($procedimentos as $procedimento) {
                        exibirProcedimento($procedimento, 'agendaCadastrado.php');
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>