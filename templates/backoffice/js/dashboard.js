window.onload = () => {

  var cookieDuration = document.getElementById('cookie-duration');

  display_duration_note();
  cookieDuration.oninput = () => {

    display_duration_note();

  } 

  function display_duration_note () {

    let totalSeconds = cookieDuration.value;

    let hours = Math.floor(totalSeconds / 3600);
    totalSeconds %= 3600;
    let minutes = Math.floor(totalSeconds / 60);
    let seconds = totalSeconds % 60;

    const result = String(hours).padStart(2, "0")+":"+String(minutes).padStart(2, "0");

    document.getElementById('cookie-duration-output').innerHTML = "("+result+")";

  }

}