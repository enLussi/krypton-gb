const agent_radio = document.getElementById('involved1');
const contact_radio = document.getElementById('involved2');
const cible_radio = document.getElementById('involved3');

const speciality = document.getElementById('speciality');

const form_involved = document.getElementById('mission-involved');

agent_spe();


form_involved.onchange = () => {

  agent_spe();

}

form_involved.onsubmit = async (e) => {
  e.preventDefault();

  if(form_involved.checkValidity()) {
    await fetch ('/admin/kgb-involved/modify', {
      method: "POST",
      body: new FormData(form_involved)
    }).then((r) => {
      if(r.status === 200) {
        console.log('OK')

        setTimeout(() => {
          location.replace('/admin/kgb');
        }, 2000);
        
      }
    });
  }
}

function agent_spe() {

  if(speciality != null){
    if(agent_radio.checked) {
      console.log('Agent');
      speciality.style.display = "block";
    } else {
      console.log('Pas Agent');
      speciality.style.display = "none";
    }
  }
}