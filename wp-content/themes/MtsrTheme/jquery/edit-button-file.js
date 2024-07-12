
// document.getElementById('file-upload').onchange = function(e) {
//     document.querySelector('.custom-file-upload').innerText = e.target.files[0].name || 'Прикрепить изображение!';
//     document.querySelector('.custom-file-upload').classList.add('added');
//   };
  function imgPopup(link) {
    document.getElementById('popup').className = 'popup';
    document.getElementById('img_popup').src = link;
  }
  function closePopup() {
    document.getElementById('popup').className = 'popup hidden';
    document.getElementById('img_popup').src = '';
  }
  function changeButtonImg(id){
    console.log('change button');
  document.getElementById(id).onchange = function(e) {
    document.querySelector('.'+id).innerText = e.target.files[0].name || 'Прикрепить изображение!';
    document.querySelector('.'+id).classList.add('added');
  
  };
}