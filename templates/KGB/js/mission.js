const country_selector = document.getElementById('country');

country_selector.onchange = async () => {
  console.log(country_selector.value);
  fetchagentbycountry(country_selector.value).then((t) => {
    console.log(t);
  });
}

async function fetchcountry() {

  return await fetch('/admin/kgb-new-mission/country', {
    method: "POST",
  }).then((r) => {
    if(r.status === 200) {
      return r.text();
    }
  })
}

async function fetchagentbycountry(id_country) {


  let data = new FormData();
  data.append('country', id_country);

  return await fetch('/admin/kgb-new-mission/agentbycountry', {
    method: "POST",
    body: data,
  }).then((r) => {
    if(r.status === 200) {
      return r.text();
    }
  })
}