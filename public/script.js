// Validación de DNI en formularios
function validarDNI(dni) {
  return /^[0-9]{8}$/.test(dni);
}

// Validación en registro entrada/salida
function validarFormulario() {
  const dniInput = document.querySelector('input[name="dni"]');
  if (dniInput && !validarDNI(dniInput.value)) {
    alert("El DNI debe contener exactamente 8 dígitos.");
    dniInput.focus();
    return false;
  }
  return true;
}

// Auto completar fecha/hora si existe el campo
window.onload = () => {
  const hoy = new Date();
  const fechaInput = document.querySelector('input[name="fecha"]');
  const horaInput = document.querySelector('input[name="hora"]');
  if (fechaInput) fechaInput.value = hoy.toISOString().split('T')[0];
  if (horaInput) horaInput.value = hoy.toTimeString().slice(0,5);
};
