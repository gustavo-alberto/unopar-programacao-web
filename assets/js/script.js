// ================================
// FORMULÁRIO — Validação (index.php)
// ================================

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('zodiacForm')

  if (form) {
    form.addEventListener('submit', function (e) {
      const input = document.getElementById('data_nascimento')
      const errorMsg = document.getElementById('errorMsg')

      // Remove mensagem de erro anterior
      errorMsg.classList.add('d-none')
      errorMsg.textContent = ''

      const valor = input.value

      // 1. Campo vazio
      if (!valor) {
        e.preventDefault()
        errorMsg.textContent = 'Por favor, selecione uma data válida.'
        errorMsg.classList.remove('d-none')
        return
      }

      // 2. Valida se é uma data real
      const data = new Date(valor)
      if (isNaN(data.getTime())) {
        e.preventDefault()
        errorMsg.textContent = 'A data informada não é válida.'
        errorMsg.classList.remove('d-none')
        return
      }

      // 3. Não pode ser uma data futura
      const hoje = new Date()
      hoje.setHours(0, 0, 0, 0)
      if (data >= hoje) {
        e.preventDefault()
        errorMsg.textContent = 'A data de nascimento não pode ser no futuro.'
        errorMsg.classList.remove('d-none')
        return
      }

      // 4. Ano mínimo razoável
      if (data.getFullYear() < 1900) {
        e.preventDefault()
        errorMsg.textContent = 'Por favor, insira um ano a partir de 1900.'
        errorMsg.classList.remove('d-none')
        return
      }
    })
  }
})

// ================================
// STAR FIELD (result.php)
// ================================

document.addEventListener('DOMContentLoaded', () => {
  const starField = document.getElementById('starField')

  if (starField) {
    for (let i = 0; i < 120; i++) {
      const star = document.createElement('div')
      star.className = 'star'

      const size = Math.random() * 3
      star.style.width = size + 'px'
      star.style.height = size + 'px'
      star.style.left = Math.random() * 100 + '%'
      star.style.top = Math.random() * 100 + '%'
      star.style.animationDelay = Math.random() * 3 + 's'

      starField.appendChild(star)
    }
  }
})
