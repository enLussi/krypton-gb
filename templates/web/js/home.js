const searchInputMission = document.getElementById('search-mission');
const missionContainer = document.getElementById('mission-result');

searchInputMission.oninput = () => {
  searchMission();
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
      '<div class="list">'+
      '<p><a href="?mission='+missions[element].id+'">'+missions[element].name_code+'</a></p>'+
      '<p>'+missions[element].status+'</p>'+
      '<p>'+missions[element].type+'</p>'+
      '<p>('+missions[element].country+')</p>'+
      '</div>';
    });

    return;
  });
}