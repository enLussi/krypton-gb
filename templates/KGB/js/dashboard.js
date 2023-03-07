const remove = document.querySelectorAll('.remove');
const searchInputInvolved = document.getElementById('search-involved');
const involvedContainer = document.getElementById('involved');

remove.forEach(element => {
  element.onclick = async () => {

    let arr = element.getAttribute('id').split("-");

    let data = new FormData();
    data.append('remove', true);
    data.append('id', arr[1]);

    let url = "";
    console.log(arr);
    switch(arr[0]){
      case 'mission':
        url = '/admin/kgb-mission/modify';
        break;
      case 'involved':
        url = '/admin/kgb-involved/modify';
        break;
      case 'hideout':
        url = '/admin/kgb-hideout/modify';
        break;
      default:
        return;
    }

    await fetch (url, {
      method: "POST",
      body: data
    }).then((r) => {
      if(r.status === 200) {
        console.log('OK')

        setTimeout(() => { 
          location.replace('/admin/kgb');
        }, 2000);
      }
    });
  }
});

searchInputInvolved.onchange = async () => {
  involvedContainer.innerHTML ='<input type="text" name="search-involved" id="search-involved" placeholder="" value="'+searchInputInvolved.value+'">';
  let data = new FormData();
  data.append('search', searchInputInvolved.value);
  await fetch ("/admin/kgb-involved/search", {
    method: "POST",
    body: data
  }).then((r) => {
    if(r.status === 200) {
      return r.text();
    }
  }).then((t) => {
    const { agents, contacts, targets } = JSON.parse(t);

    Object.keys(agents).forEach(element => {
      involvedContainer.innerHTML += 
      '<div class="list">'+
      '<p>'+agents[element].name_code+'</p>'+
      '<p>'+agents[element].firstname+' '+agents[element].lastname+'</p>'+
      '<p>'+agents[element].nationality+'</p>'+
      '<a role="button" href="/admin/kgb-involved?agent='+agents[element].id+'" class="btn btn-primary btn-sm">Modify</a>'+
      '<button id="involved-'+agents[element].id+'" type="button" class="btn btn-danger btn-sm remove">Remove</button>'+
      '</div>';
    });

    return;
  });
  

}