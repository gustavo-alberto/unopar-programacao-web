<?php
$pageTitle = 'Resultado do seu signo';

// Recebe a data de nascimento via POST
$data_nascimento = $_POST['data_nascimento'] ?? '';

// Carrega o arquivo XML com os signos
$signos = simplexml_load_file("signos.xml");

// -----------------------------------------------
// Funções auxiliares para manipulação de datas
// -----------------------------------------------

/**
 * Monta uma data DateTime válida para dataInicio e dataFim do XML,
 * usando o mesmo ano do nascimento (ou ajustando para Capricórnio).
 *
 * @param string $mmdd   Data no formato MM-DD (ex: "01-20")
 * @param int    $ano    Ano de referência
 * @return DateTime
 */
function montarData(string $mmdd, int $ano): DateTime {
    return new DateTime($ano . '-' . str_replace('-', '-', $mmdd));
}

/**
 * Verifica se a data de nascimento está dentro do range [inicio, fim].
 * Lida com Capricórnio que cruza a virada do ano (dez → jan).
 */
function dentroDoRange(DateTime $nascimento, DateTime $inicio, DateTime $fim): bool {
    // Se o início for depois do fim, o signo cruza a virada do ano
    if ($inicio > $fim) {
        // Ex: Capricórnio 22-dez até 19-jan do próximo ano
        return $nascimento >= $inicio || $nascimento <= $fim;
    }
    return $nascimento >= $inicio && $nascimento <= $fim;
}

// -----------------------------------------------
// Lógica de busca do signo
// -----------------------------------------------
$signoEncontrado = null;

if (!empty($data_nascimento)) {
    $nascimento    = new DateTime($data_nascimento);
    $anoNascimento = (int) $nascimento->format('Y');

    foreach ($signos->signo as $signo) {
        $inicio = montarData((string) $signo->dataInicio, $anoNascimento);
        $fim    = montarData((string) $signo->dataFim,    $anoNascimento);

        // Ajuste para Capricórnio: dataInicio (12-XX) > dataFim (01-XX)
        // quando cruzam a virada do ano. Para nascidos em janeiro,
        // usamos o ano anterior para montar o início.
        if ($inicio > $fim) {
            $mesNascimento = (int) $nascimento->format('m');
            if ($mesNascimento == 1) {
                // Nasceu em janeiro: início deve ser no ano anterior
                $inicio = montarData((string) $signo->dataInicio, $anoNascimento - 1);
            } else {
                // Nasceu em dezembro: fim deve ser no ano seguinte
                $fim = montarData((string) $signo->dataFim, $anoNascimento + 1);
            }
        }

        if (dentroDoRange($nascimento, $inicio, $fim)) {
            $signoEncontrado = $signo;
            break;
        }
    }
}

include 'layouts/header.php';
?>

    <div class="star-field" id="starField"></div>

    <!-- Main -->
    <main class="flex-grow-1 container d-flex justify-content-center align-items-center py-5">

      <?php if ($signoEncontrado): ?>

        <!-- Result -->
        <div class="card card-custom shadow-lg p-4 p-md-5 text-center col-md-8 col-lg-6">
          <h1 class="display-5 fw-bold mb-2 text-light"><?php echo htmlspecialchars((string) $signoEncontrado->signoNome); ?></h1>
          <p class="text-primary fw-semibold mb-4">
            <?php
              // Exibe as datas no formato legível (ex: "20 Jan – 18 Fev")
              $inicioFormatado = DateTime::createFromFormat('m-d', (string) $signoEncontrado->dataInicio);
              $fimFormatado    = DateTime::createFromFormat('m-d', (string) $signoEncontrado->dataFim);

              $meses = ['', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                             'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

              $diaInicio = $inicioFormatado->format('d');
              $mesInicio = $meses[(int) $inicioFormatado->format('m')];
              $diaFim    = $fimFormatado->format('d');
              $mesFim    = $meses[(int) $fimFormatado->format('m')];

              echo "{$diaInicio} {$mesInicio} – {$diaFim} {$mesFim}";
            ?>
          </p>

          <hr class="border-secondary w-25 mx-auto mb-4" />

          <h5 class="text-uppercase text-secondary mb-2">Essência do signo</h5>
          <p class="text-light mb-4"><?php echo htmlspecialchars((string) $signoEncontrado->descricao); ?></p>

          <h6 class="text-uppercase text-secondary mb-3">Principais características</h6>
          <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
            <?php
              $keywords = explode(',', (string) $signoEncontrado->keywords);
              foreach ($keywords as $kw): ?>
                <span class="trait-tag"><?php echo htmlspecialchars(trim($kw)); ?></span>
            <?php endforeach; ?>
          </div>

          <a href="index.php" class="btn btn-primary fw-bold"> ← Descobrir outro signo </a>
        </div>

      <?php else: ?>

        <!-- Error -->
        <div class="card card-custom shadow-lg p-5 text-center col-md-6">
          <h2 class="mb-3">Nenhum dado encontrado</h2>
          <p class="text-secondary mb-4">
            Não foi possível encontrar seu signo. Volte para a página inicial e informe sua data de nascimento.
          </p>
          <a href="index.php" class="btn btn-outline-primary">Voltar</a>
        </div>

      <?php endif; ?>

    </main>

<?php include 'layouts/footer.php'; ?>
