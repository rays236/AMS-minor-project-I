
var elems = document.getElementsByClassName('confirmation');
var confirmIt = function(e){
  if (!confirm('Are you sure?')) e.preventDefault();
};
for (var i = 0 , l = elems.length; i < l; i++){
  elems[i].addEventListener('click',confirmIt, false);
}

var plink = document.getElementsByClassName('productLink');
var linker = function(){

  var productName = this.getAttribute("data-name");

  document.getElementById("tbl_name").value = productName;

  document.getElementById("myModal").style.display = "block";
}
for (var i = 0 , l = plink.length; i < l; i++){
  plink[i].addEventListener('click',linker, false);
}

  var modal = document.getElementById("myModal");
  var closeBtn = document.getElementsByClassName("close")[0];

  closeBtn.onclick = function() {
    modal.style.display = 'none';
  }

  window.onclick = function(event) {
    if (event.target == modal){
      modal.style.display = 'none';
    }
  }