const form = document.getElementById('mission-prepare');

const country_selector = document.getElementById('country');
const type_selector = document.querySelectorAll('input[name="type"]');
const target_selector = document.querySelectorAll('input[name="target"]');
const agent_selector = document.getElementById('agent');
const contact_selector = document.getElementById('contact');
const hideout_selector = document.getElementById('hideout');

initForm();

form.onchange = async () => {
  updateForm();
};

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

    agent_selector.innerHTML = "";
    contact_selector.innerHTML = "";
    hideout_selector.innerHTML = "";
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

      agent_selector.innerHTML += `
      <div class="form-check">
        <input 
          class="form-check-input" 
          type="checkbox" 
          value="`+element['row_id']+`" 
          id="agent-`+element['row_id']+`" 
          name="agent-`+element['row_id']+`"
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
      contact_selector.innerHTML += `
      <div class="form-check">
        <input 
          class="form-check-input" 
          type="checkbox" 
          value="`+element['row_id']+`" 
          id="contact-`+element['row_id']+`" 
          name="contact-`+element['row_id']+`"
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
      hideout_selector.innerHTML += `
      <div class="form-check">
        <input 
          class="form-check-input" 
          type="checkbox" 
          value="`+element['row_id']+`" 
          id="hideout-`+element['row_id']+`" 
          name="hideout-`+element['row_id']+`"
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

// country_selector.onchange = async () => {
//   fetchOnChange({
//     'country': country_selector.value
//   }, [contact_selector, hideout_selector], ['contacts', 'hideouts']);
// }

// function fetchOnChange(post,selectors, type) {
//   fetchData(post).then((t) => {
//     selectors.forEach((selector, key) => {
//       fillSelect(selector, JSON.parse(t), type[key])
//     })
//   });
// }

// function fillSelect(id, data, type) {

//   for (i = id.options.length; i > 0; i--) {
//     id.remove(i);
//   }

//   if (typeof(data) === 'object'){

//     switch(type) {
//       case 'hideouts':
//         data[type].forEach(element => {
          
//           const checkbox = document.create

//           id.innerHTML += `
//             <input class="form-check-input" type="checkbox" value="`+element['row_id']+`" id="target-`+element['row_id']+`" name="target-`+element['row_id']+`">
//             <label class="form-check-label" for="target-`+element['row_id']+`">
//             `+element['label'] + ` ` + element['name_code'] + ` ( ` + element['noun'] + ` )`+`
//             </label>
//           `;
//         });
//         break;
//       default:
//         data[type].forEach(element => {
//           id.innerHTML += `
//           <input class="form-check-input" type="checkbox" value="`+element['row_id']+`" id="target-`+element['row_id']+`" name="target-`+element['row_id']+`">
//           <label class="form-check-label" for="target-`+element['row_id']+`">
//           `+element['firstname'] + ` ` + element['lastname'] + ` ( ` + element['adjective'] + ` )`+`
//           </label>
//         `;
//         });
//         break;
//     }
//   }
// }

// function addOption (val, txt, select) {
//   let option = document.createElement("option");
//   option.value = val;
//   option.text = txt;
//   select.add(option, null);
// }

// async function fetchcountry() {

//   return await fetch('/admin/kgb-new-mission/country', {
//     method: "POST",
//   }).then((r) => {
//     if(r.status === 200) {
//       return r.text();
//     }
//   })
// }

// async function fetchData(info_array) {

//   let data = new FormData();


//   Object.keys(info_array).forEach((key, id) => {
//     data.append(key, info_array[key]);
//   });
  

//   return await fetch('/admin/kgb-new-mission/fetch', {
//     method: "POST",
//     body: data,
//   }).then((r) => {
//     if(r.status === 200) {
//       return r.text();
//     }
//   })
// }