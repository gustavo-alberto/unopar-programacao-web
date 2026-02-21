<?php
$pageTitle = 'Descubra seu signo';
include 'layouts/header.php';
?>

    <!-- Main -->
    <main class="flex-grow-1 d-flex flex-column justify-content-center align-items-center container py-5">
      <section class="text-center mb-5">
        <h1 class="display-5 fw-bold">Descubra <span style="color: #d4af37">seu signo</span></h1>
        <p class="text-secondary fs-5">Descubra o mapa cósmico da sua personalidade e destino.</p>
      </section>

      <section class="col-md-5 col-lg-4">
        <div class="card card-custom p-4 shadow-lg">
          <form id="zodiacForm" method="POST" action="result.php">
            <div class="mb-3">
              <label for="data_nascimento" class="form-label text-uppercase fw-semibold text-light">
                Sua data de nascimento
              </label>
              <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required />
              <small id="errorMsg" class="text-danger d-none"> Por favor, selecione uma data válida. </small>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold glow-effect">Descobrir meu signo →</button>
          </form>
        </div>
      </section>
    </main>

<?php include 'layouts/footer.php'; ?>
