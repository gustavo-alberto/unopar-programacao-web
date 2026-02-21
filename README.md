# Descubra seu Signo 🔮

Projeto desenvolvido para a disciplina de **Programação Web** da UNOPAR.

A aplicação permite que o usuário informe sua data de nascimento e descubra qual é o seu signo do zodíaco.

## Tecnologias utilizadas

- PHP
- HTML & CSS
- Bootstrap
- XML (dados dos signos)

## Como executar

### Pré-requisitos

- [XAMPP](https://www.apachefriends.org/) instalado na sua máquina.

### Passo a passo

1. Abra a pasta de instalação do XAMPP (geralmente `C:\xampp\htdocs\`).
2. Crie uma pasta chamada `projeto` dentro de `htdocs`.
3. Copie a pasta `assets` deste repositório para dentro de `htdocs\projeto\`.
4. A estrutura final deve ficar assim:
   ```
   C:\xampp\htdocs\projeto\assets\
   ```
5. Inicie o **Apache** pelo painel de controle do XAMPP.
6. Abra o navegador e acesse:
   ```
   http://localhost/projeto/assets/
   ```

## Funcionamento

- Na página inicial, o usuário seleciona sua data de nascimento e clica em **"Descobrir meu signo"**.
- O sistema processa a data via PHP, consulta os dados em `signos.xml` e exibe o signo correspondente na página de resultado.
