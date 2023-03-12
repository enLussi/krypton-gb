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

form_hideout.onsubmit = async (e) => {
  e.preventDefault();

  if(address_regex.test(address_input.value)){
    if(form_hideout.checkValidity()) {
      await fetch ('/admin/kgb-hideout/modify', {
        method: "POST",
        body: new FormData(form_hideout)
      }).then((r) => {
        if(r.status === 200) {
          console.log('OK')

          setTimeout(() => {
            location.replace('/admin/kgb');
          }, 1000);
        }
      });
    }
    return;
  } 
  modal_warner.style.display = "block";
  message_warner.innerHTML += "Donner une adresse valide (exemple.: 23 Rue de la Paix, Paris)";

}

