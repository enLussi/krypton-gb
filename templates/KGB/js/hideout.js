const form_hideout = document.getElementById('mission-hideout');

const address_input = document.getElementById('address');
const address_regex = /^[0-9]+\s+[A-Za-z0-9'\.\-\s\,]+\s*,\s*[A-Za-z]+\s*$/

const modal_warner = document.getElementById('modal-warner-form');
const message_warner = document.getElementById('modal-warner-form-message');
const close = document.getElementById('modal-close');

close.onclick = () => {
  modal_warner.style.display = "none";
  message_warner.innerHTML = "";
}

form_hideout.onsubmit = (e) => {
  e.preventDefault();
  console.log(address_regex.test(address_input.value));
  if(address_regex.test(address_input.value)){
    //form_hideout.onsubmit();
    return;
  } 
  modal_warner.style.display = "block";
  message_warner.innerHTML += "Donner une adresse valide (exemple.: 23 Rue de la Paix, Paris)";

}