$(document).ready(
  $("#uebersichts_map_area").click(function(e){
  img = document.getElementById("uebersichts_map")

  $("#uebersichts_map_X").val(e.pageX-img.offsetLeft)
  $("#uebersichts_map_Y").val(e.pageY-img.offsetTop)
  })
)

