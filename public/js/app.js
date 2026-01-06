// Public JS for helpers used in the admin & frontend
document.addEventListener('DOMContentLoaded', function(){
  // Auto dismiss alerts after 5s
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(a=> setTimeout(()=>{ if(a.classList.contains('show')) a.classList.remove('show'); }, 5000));

  // Confirm delete forms
  document.querySelectorAll('form[data-confirm]').forEach(form => {
    form.addEventListener('submit', function(e){
      const msg = form.getAttribute('data-confirm') || 'Yakin akan menghapus?';
      if(!confirm(msg)) e.preventDefault();
    });
  });

});

function previewImageEvent(e, selector){
  const file = e.target.files[0];
  const img = document.querySelector(selector);
  if(!file) { if(img) img.classList.add('d-none'); return; }
  if(img){ img.src = URL.createObjectURL(file); img.classList.remove('d-none'); }
}
window.previewImageEvent = previewImageEvent;
