 $(document).ready(function(){
  $(':checkbox').iphoneStyle({
    checkedLabel: 'Online',
    uncheckedLabel: 'Offline'
  });

  $(':checkbox').change(function(){
    console.log("changed")
    if(this.is(':checked')){
      console.log("checked")
    }else{
      console.log("unchecked")
    }
  });

  $(":checkbox").change(function() {
    console.log("sd")
    if(this.checked) {
        //Do stuff
    }
  });

});