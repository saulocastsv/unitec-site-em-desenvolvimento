/* eslint-disable no-console */
document.addEventListener('DOMContentLoaded', () => {
  const form       = document.getElementById('contactForm');
  const statusSpan = document.getElementById('formStatus');
  const sendBtn    = document.getElementById('sendBtn');

  const setStatus = (msg, isError = false) => {
    statusSpan.textContent = msg;
    statusSpan.classList.toggle('error', isError);
  };

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    setStatus('Enviando...');
    sendBtn.disabled = true;

    try {
      const formData = new FormData(form);
      const response = await fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: { 'Accept': 'application/json' }
      });

      const text = await response.text();
      if (response.ok) {
        setStatus(text);
        form.reset();
      } else {
        setStatus(text || 'Ocorreu um erro no envio.', true);
      }
    } catch (err) {
      console.error(err);
      setStatus('Falha de comunicação com o servidor.', true);
    } finally {
      sendBtn.disabled = false;
    }
  });
});
