const agent_radio = document.getElementById('involved1');
const contact_radio = document.getElementById('involved2');
const cible_radio = document.getElementById('involved3');

const speciality = document.getElementById('speciality');

const form_involved = document.getElementById('mission-involved');


form_involved.onchange = () => {

  if(agent_radio.checked) {
    console.log('Agent');
    speciality.style.display = "block";
  } else {
    console.log('Pas Agent');
    speciality.style.display = "none";
  }

}

