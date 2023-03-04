const form_prepare = document.getElementById('mission-prepare');
const form_involved = document.getElementById('mission-involved');
const submitter = document.getElementById('submitter');

const country_selector = document.getElementById('country');
const type_selector = document.querySelectorAll('input[name="type[]"]');
const target_selector = document.querySelectorAll('input[name="target[]"]');
const target_container = document.getElementById('target');
const agent_selector = document.getElementById('input[name="agent[]"]');
const agent_container = document.getElementById('agent');
const contact_selector = document.getElementById('input[name="contact[]"]');
const contact_container = document.getElementById('contact');
const hideout_selector = document.getElementById('input[name="hideout[]"]');
const hideout_container = document.getElementById('hideout');

const modal_warner = document.getElementById('modal-warner-form');
const message_warner = document.getElementById('modal-warner-form-message');
const close = document.getElementById('modal-close');

close.onclick = () => {
  modal_warner.style.display = "none";
  message_warner.innerHTML = "";
}

initForm();

form_prepare.onchange = async () => {
  updateForm();
};

submitter.onclick = async () => {
  message_warner.innerHTML = "";
  let allData = new FormData(form_prepare);
  let toAppend = new FormData(form_involved);

  for (const pair of toAppend.entries()) {
    allData.append(pair[0], pair[1]);
  }

  if(
    form_prepare.checkValidity() && 
    form_involved.checkValidity() &&
    document.querySelectorAll('input[name="target[]"]:checked').length > 0 &&
    document.querySelectorAll('input[name="type[]"]:checked').length > 0 &&
    document.querySelectorAll('input[name="agent[]"]:checked').length > 0 &&
    document.querySelectorAll('input[name="contact[]"]:checked').length > 0 &&
    document.getElementById('start').value < document.getElementById('end').value
    ) {
    await fetch ('/admin/kgb-new-mission/send-mission', {
      method: "POST",
      body: allData
    }).then((r) => {
      if(r.status === 200) {
        
      }
    });
  } else {
    if(document.querySelectorAll('input[name="target[]"]:checked').length == 0) {
      modal_warner.style.display = "block";
      message_warner.innerHTML += "Sélectionner au moins une cible<br>";
    }
    if(document.querySelectorAll('input[name="type[]"]:checked').length == 0) {
      modal_warner.style.display = "block";
      message_warner.innerHTML += "Sélectionner un type de mission<br>";
    }
    if(document.querySelectorAll('input[name="agent[]"]:checked').length == 0) {
      modal_warner.style.display = "block";
      message_warner.innerHTML += "Sélectionner au moins un agent<br>";
    }
    if(document.querySelectorAll('input[name="contact[]"]:checked').length == 0) {
      modal_warner.style.display = "block";
      message_warner.innerHTML += "Sélectionner au moins un contact<br>";
    }
    if (document.getElementById('start').value > document.getElementById('end').value) {
      modal_warner.style.display = "block";
      message_warner.innerHTML += "Sélectionner des dates cohérentes<br>";
    }
    form_prepare.reportValidity();
    form_involved.reportValidity();

    return;
  }

  location.reload();

}

async function initForm() {
  const data = await fetch('/admin/kgb-new-mission/fetch', {
    method: "POST",
  }).then((r) => {
    if(r.status === 200) {
      return r.text();
    }
  }).then((t) => {
    let fetchdata = JSON.parse(t);

    let disabled = '';

    agent_container.innerHTML = "";
    contact_container.innerHTML = "";
    hideout_container.innerHTML = "";
    let target_country = [];
    let type_spe = 0;

    target_selector.forEach(element => {
      if(element.checked) {
        Object.keys(fetchdata['target']).forEach((key, t) => {
          if(fetchdata['target'][t]['row_id'] == element.value) {
            target_country.push(parseInt(fetchdata['target'][t]['country_id']));   
          }
        })
      }
    });

    type_selector.forEach(element => {
      if(element.checked) {
        type_spe = parseInt(element.value);
      }
    });

    fetchdata['agent'].forEach(element => {

      let bool_target_country = target_country.length > 0 ? target_country.includes(element['country_id']) : true;

      disabled = (!element['spe'].includes(type_spe) || bool_target_country) ?
      `disabled` : ``;

      agent_container.innerHTML += `
      <div class="form-check">
        <input 
          class="form-check-input" 
          type="checkbox" 
          value="`+element['row_id']+`" 
          id="agent-`+element['row_id']+`" 
          name="agent[]"
          `+ disabled +`
          >
        <label class="form-check-label" for="agent-`+element['row_id']+`">
        `+element['firstname'] + ` ` + element['lastname'] + ` [ ` + element['adjective'] + ` ]`+`
        </label>
      </div>
      `
    });

    fetchdata['contact'].forEach(element => {
      disabled = country_selector.value != element['country_id'] ? `disabled` : ``;
      contact_container.innerHTML += `
      <div class="form-check">
        <input 
          class="form-check-input" 
          type="checkbox" 
          value="`+element['row_id']+`" 
          id="contact-`+element['row_id']+`" 
          name="contact[]"
          `+ disabled +`
        >
        <label class="form-check-label" for="contact-`+element['row_id']+`">
        `+element['firstname'] + ` ` + element['lastname'] + ` [ ` + element['adjective'] + ` ]`+`
        </label>
      </div>
      `
    });

    fetchdata['hideout'].forEach(element => {
      disabled = country_selector.value != element['country_id'] ? `disabled` : ``;
      hideout_container.innerHTML += `
      <div class="form-check">
        <input 
          class="form-check-input" 
          type="checkbox" 
          value="`+element['row_id']+`" 
          id="hideout-`+element['row_id']+`" 
          name="hideout[]"
          `+ disabled +`
          >
        <label class="form-check-label" for="hideout-`+element['row_id']+`">
        `+element['label'] + ` [ ` + element['noun'] + ` ]`+`
        </label>
      </div>
      `
    });
  });
}

async function updateForm() {
  const data = await fetch('/admin/kgb-new-mission/fetch', {
    method: "POST",
  }).then((r) => {
    if(r.status === 200) {
      return r.text();
    }
  }).then((t) => {
    let fetchdata = JSON.parse(t);

    let disabled = '';
    let target_country = [];
    let type_spe = 0;

    console.log(type_selector);

    target_selector.forEach(element => {
      if(element.checked) {
        Object.keys(fetchdata['target']).forEach((key, t) => {
          if(fetchdata['target'][t]['row_id'] == element.value) {
            target_country.push(parseInt(fetchdata['target'][t]['country_id']));   
          }
        })
      }
    });

    type_selector.forEach(element => {
      if(element.checked) {
        type_spe = parseInt(element.value);
      }
    });

    fetchdata['agent'].forEach(element => {
      let bool_target_country = target_country.length > 0 ? target_country.includes(element['country_id']) : true;

      disabled = (!element['spe'].includes(type_spe) || bool_target_country) ?
      true : false;

      document.getElementById('agent-'+element['row_id']).disabled = disabled;
      disabled && (document.getElementById('agent-'+element['row_id']).checked = false)

    });

    fetchdata['contact'].forEach(element => {
      disabled = country_selector.value != element['country_id'] ? true : false;
      document.getElementById('contact-'+element['row_id']).disabled = disabled;
      disabled && (document.getElementById('contact-'+element['row_id']).checked = false)
    });

    fetchdata['hideout'].forEach(element => {
      disabled = country_selector.value != element['country_id'] ? `disabled` : ``;
      document.getElementById('hideout-'+element['row_id']).disabled = disabled;
      disabled && (document.getElementById('hideout-'+element['row_id']).checked = false)
    });

  });
};
