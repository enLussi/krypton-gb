const remove = document.querySelectorAll('.remove');

const searchInputInvolved = document.getElementById('search-involved');
const involvedContainer = document.getElementById('involved-result');

const searchInputMission = document.getElementById('search-mission');
const missionContainer = document.getElementById('mission-result');

const searchInputHideout = document.getElementById('search-hideout');
const hideoutContainer = document.getElementById('hideout-result');

remove.forEach(element => {
  element.onclick = async () => {

    let arr = element.getAttribute('id').split("-");

    let data = new FormData();
    data.append('remove', true);
    data.append('id', arr[1]);

    console.log(arr[0], arr[1]);

    let url = "";
    
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

searchInputInvolved.oninput = () => {
  searchInvolved();
}

searchInputMission.oninput = () => {
  searchMission();
}

searchInputHideout.oninput = () => {
  searchHideout();
}

async function searchInvolved(){
  
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
    involvedContainer.innerHTML = ""
    const { agents, contacts, targets } = JSON.parse(t);

    Object.keys(agents).forEach(element => {
      involvedContainer.innerHTML += 
      '<tr>'+
      '<td>'+agents[element].name_code+'</td>'+
      '<td>'+agents[element].firstname+' '+agents[element].lastname+'</td>'+
      '<td>('+agents[element].specialities.join(', ')+')</td>'+
      '<td>'+agents[element].nationality+'</td>'+
      '<a role="button" href="/admin/kgb-involved?agent='+agents[element].id+'" class="btn btn-primary btn-sm">Modify</a>'+
      '<button id="involved-'+agents[element].id+'" type="button" class="btn btn-danger btn-sm remove">Remove</button></td>'+
      '</div>';
    });

    Object.keys(contacts).forEach(element => {
      involvedContainer.innerHTML += 
      '<tr>'+
      '<td>'+contacts[element].name_code+'</td>'+
      '<td>'+contacts[element].firstname+' '+contacts[element].lastname+'</td>'+
      '<td>'+contacts[element].nationality+'</td>'+
      '<td><a role="button" href="/admin/kgb-involved?contact='+contacts[element].id+'" class="btn btn-primary btn-sm">Modify</a>'+
      '<button id="involved-'+contacts[element].id+'" type="button" class="btn btn-danger btn-sm remove">Remove</button></td>'+
      '</div>';
    });

    Object.keys(targets).forEach(element => {
      involvedContainer.innerHTML += 
      '<tr>'+
      '<td>'+targets[element].name_code+'</td>'+
      '<td>'+targets[element].firstname+' '+targets[element].lastname+'</td>'+
      '<td>'+targets[element].nationality+'</td>'+
      '<td><a role="button" href="/admin/kgb-involved?target='+targets[element].id+'" class="btn btn-primary btn-sm">Modify</a>'+
      '<button id="involved-'+targets[element].id+'" type="button" class="btn btn-danger btn-sm remove">Remove</button></td>'+
      '</tr>';
    });

    return;
  });
}

async function searchMission(){
  
  let data = new FormData();
  data.append('search', searchInputMission.value);
  await fetch ("/admin/kgb-mission/search", {
    method: "POST",
    body: data
  }).then((r) => {
    if(r.status === 200) {
      return r.text();
    }
  }).then((t) => {
    missionContainer.innerHTML = ""
    const { missions } = JSON.parse(t);

    Object.keys(missions).forEach(element => {
      missionContainer.innerHTML += 
      '<tr>'+
      '<td>'+missions[element].name_code+'</td>'+
      '<td>'+missions[element].status+'</td>'+
      '<td>('+missions[element].country+')</td>'+
      '<td><a role="button" href="/admin/kgb-mission?mission='+missions[element].id+'" class="btn btn-primary btn-sm">Modify</a>'+
      '<button id="mission-'+missions[element].id+'" type="button" class="btn btn-danger btn-sm remove">Remove</button></td>'+
      '</tr>';
    });

    return;
  });
}

async function searchHideout(){
  
  let data = new FormData();
  data.append('search', searchInputHideout.value);
  await fetch ("/admin/kgb-hideout/search", {
    method: "POST",
    body: data
  }).then((r) => {
    if(r.status === 200) {
      return r.text();
    }
  }).then((t) => {
    hideoutContainer.innerHTML = ""
    const { hideouts } = JSON.parse(t);

    Object.keys(hideouts).forEach(element => {
      hideoutContainer.innerHTML += 
      '<tr>'+
      '<td>'+hideouts[element].name_code+'</td>'+
      '<td>'+hideouts[element].address+'</td>'+
      '<td>('+hideouts[element].country+')</td>'+
      '<td>('+hideouts[element].type+')</td>'+
      '<td><a role="button" href="/admin/kgb-hideout?hideout='+hideouts[element].id+'" class="btn btn-primary btn-sm">Modify</a>'+
      '<button id="hideout-'+hideouts[element].id+'" type="button" class="btn btn-danger btn-sm remove">Remove</button></td>'+
      '</tr>';
    });

    return;
  });
}