
# 🌐 Site da Escola Técnica Unitec

Este é o repositório do site institucional da **Escola Técnica Unitec**, desenvolvido com foco em simplicidade, leveza e facilidade de manutenção.

---

## 🚀 Tecnologias Utilizadas

- **HTML5**: estrutura das páginas
- **CSS3**: estilização visual
- **LESS**: pré-processador CSS
- **Bootstrap**: layout e responsividade
- **JavaScript**: funcionalidades básicas
- **jQuery**: interações (via plugins)
- **Typeform**: para o formulário de contato

---

## 🧱 Estrutura de Pastas

```
unitec-site-em-desenvolvimento-main/
│
├── index.html
├── contato.html
├── institucional.html
├── nossoscursos.html
├── [diversas páginas de cursos].html
├── style.css / style.less
│
├── assets/
│   └── css/
│       ├── bootstrap.min.css
│       ├── animate.css
│       ├── font-awesome.min.css
│       ├── magnific-popup.css
│       ├── owl.carousel.css
│       ├── responsive.css
│       └── off-canvas.css
```

---

## ✍️ Como Realizar Alterações

### 1. Conteúdo
Edite qualquer arquivo `.html` com um editor como o VS Code.

### 2. Estilo
Edite `style.css` diretamente ou `style.less` e use um compilador para gerar o CSS.

### 3. Adição de Cursos
Duplique uma página de curso existente, personalize o conteúdo e adicione o link em `nossoscursos.html`.

### 4. Formulário Typeform
Este site utiliza **Typeform** para o formulário de contato.

- O formulário pode ser encontrado no arquivo `contato.html`.
- Procure por este trecho no código:
  ```html
  <iframe src="https://form.typeform.com/to/SEUID" ... ></iframe>
  ```

Substitua o link pelo seu próprio formulário no [Typeform](https://www.typeform.com).

---

## 🧪 Como Rodar Localmente

1. Extraia o projeto.
2. Clique em `index.html` para abrir no navegador.

Ou use servidor local com Python:
```bash
cd unitec-site-em-desenvolvimento-main
python -m http.server 8000
```
Acesse: [http://localhost:8000](http://localhost:8000)

---

## ☁️ Como Subir Para o GitHub

1. Crie um repositório em https://github.com
2. Use o terminal:
```bash
git init
git add .
git commit -m "Versão inicial do site Unitec"
git branch -M main
git remote add origin https://github.com/SEU-USUARIO/unitec-site-em-desenvolvimento.git
git push -u origin main
```

---

## 🌐 Como Publicar na HostGator

### cPanel (recomendado)
1. Acesse o cPanel > **Gerenciador de Arquivos**
2. Vá até `public_html/` e envie os arquivos

### FTP (FileZilla)
1. Configure o acesso com seu host, usuário e senha
2. Envie os arquivos para `public_html/`

---

## 📌 Melhorias Futuras

- Modularização com includes (PHP)
- Backend para formulários (ex: PHP ou Node)
- Integração com CMS leve
- Melhorias em SEO e acessibilidade

---

Desenvolvido para uso interno e institucional da **Escola Técnica Unitec**.
