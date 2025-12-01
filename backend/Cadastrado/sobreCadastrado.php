<?php 
include '../includes/headerCadastrado.php'; 
include '../includes/db.php';
include '../includes/profissional_functions.php';
?>

<!-- Conteúdo idêntico ao sobre.php -->
<section class="about-section">
    <div class="container">
        <div class="professional-card">
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <img src="../images/cabeleireira.png" alt="Juliana Wolff" class="professional-img">
                </div>
                <div class="col-md-8">
                    <h3>Juliana Wolff</h3>
                    <p class="text-muted">Especialista Capilar | Proprietária</p>
                    
                    <div class="mb-4">
                        <p><?php echo exibirSobre($conn); ?></p>
                    </div>
                    
                    <!-- Formação -->
                    <div class="mb-4">
                        <h5>Formação Profissional</h5>
                        <ul>
                            <?php 
                            $formacoes = getInformacoesProfissional($conn, 'formacao');
                            if (empty($formacoes)) {
                                echo '<li>Graduação em Estética e Cosmética</li>';
                                echo '<li>Pós-graduação em Tricologia Capilar</li>';
                                echo '<li>Certificação Internacional em Colorimetria</li>';
                            } else {
                                foreach ($formacoes as $formacao) {
                                    echo '<li>' . htmlspecialchars($formacao['titulo']) . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    
                    <!-- Especialidades -->
                    <div class="mb-4">
                        <h5>Especialidades</h5>
                        <div class="mt-2">
                            <?php 
                            $especialidades = getInformacoesProfissional($conn, 'especialidade');
                            if (empty($especialidades)) {
                                echo '<span class="specialty-badge">Cabelos Danificados</span>';
                                echo '<span class="specialty-badge">Coloração Vegana</span>';
                                echo '<span class="specialty-badge">Cortes Personalizados</span>';
                            } else {
                                foreach ($especialidades as $especialidade) {
                                    echo '<span class="specialty-badge">' . htmlspecialchars($especialidade['titulo']) . '</span>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Contato Rápido -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6><i class="fa fa-clock text-pink mr-2"></i>Horário de Atendimento</h6>
                        <p class="mb-1">Terça a Sexta: 9h às 19h</p>
                        <p class="mb-1">Sábado: 9h às 17h</p>
                        <p class="mb-0 text-muted"><small>Domingo: Fechado</small></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diferenciais -->
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="text-center p-3">
                    <i class="fa fa-scissors fa-3x mb-3" style="color: #f783ac;"></i>
                    <h4>Técnica</h4>
                    <p>Domínio das mais modernas técnicas internacionais de corte e coloração.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center p-3">
                    <i class="fa fa-leaf fa-3x mb-3" style="color: #f783ac;"></i>
                    <h4>Produtos</h4>
                    <p>Utilizamos apenas produtos naturais e cruelty-free em todos os tratamentos.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center p-3">
                    <i class="fa fa-heart fa-3x mb-3" style="color: #f783ac;"></i>
                    <h4>Atendimento</h4>
                    <p>Cada cliente recebe um diagnóstico completo e tratamento individualizado.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>