const searchInputMission = document.getElementById('search-mission');
const typeInputMission = document.getElementById('type');
const statusInputMission = document.getElementById('status');
const missionContainer = document.getElementById('mission-result');


searchInputMission.oninput = () => {
  searchMission();
}
typeInputMission.onchange = () => {
  searchMission();
}
statusInputMission.onchange = () => {
  searchMission();
}


async function searchMission(){
  
  let data = new FormData();
  data.append('search', searchInputMission.value);
  data.append('type', typeInputMission.value);
  data.append('status', statusInputMission.value);
  await fetch ("/mission-search", {
    method: "POST",
    body: data
  }).then((r) => {
    if(r.status === 200) {
      return r.text();
    }
  }).then((t) => {
    missionContainer.innerHTML = ""
    const { missions, type, status, country } = JSON.parse(t);

    Object.keys(missions).forEach(element => {
      missionContainer.innerHTML +=
      '<div class="mission">'+
      '<p class="code">'+missions[element].name_code+'</p>'+
      '<p class="status">'+missions[element].status+'</p>'+
      '<div class="mission-body">'+
      '<p class="country"><span class="label">Pays concerné : </span>'+missions[element].country+'</p>'+
      '<p class="type"><span class="label">Type de mission : </span>'+missions[element].type+'</p>'+
      '<p class="description">'+missions[element].description+'</p>'+
      '</div>'+
      '<p class="link-mission"><a href="?mission='+missions[element].id+'">Voir la mission</a></p>'+
      '</div>'
      ;
    });

    return;
  });
}