var x, f3, f31;

// function _(x){
//   return document.getElementById(x);
// }
//
// // fungsi tampil popup
// function bukaPopup(){
//   _('popup').style.display = 'inherit';
// }
//
// //fungsi tutup popup
// function tutupPopup(){
//      _('popup').style.display = 'none';
// }
//
//fungsi cek id_alumni sudah isi traacer study / belum
function xxx(){
  var id_alumni = 0;
  id_alumni = _('id_alumni_fk').value;
  if (id_alumni >= 1){
    alert('maaf anda sudah selesai isi ts');
    _('fieldset1').style.display='none';
    _('fieldset2').style.display='block';
  }else{
    // bukaPopup();
    alert('selamat datang');
  }
}
