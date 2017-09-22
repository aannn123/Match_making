 $('#timepicker').pickatime({
    autoclose: false,
    twelvehour: false,
    afterDone: function(Element, Time) {
        console.log(Element, Time);
    }
  });