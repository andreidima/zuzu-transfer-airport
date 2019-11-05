{{-- <div id="app">
  <vuejs-datepicker></vuejs-datepicker>
</div>
<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/vuejs-datepicker"></script>
<script>
const app = new Vue({
  el: '#app',
  components: {
  	vuejsDatepicker
  }
})
</script> --}}

<!-- French language example -->
<div id="app">
  <vuejs-datepicker :language="fr" :disabled-dates="disabledDates"></vuejs-datepicker>
</div>
<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/vuejs-datepicker"></script>
<script src="https://unpkg.com/vuejs-datepicker/dist/locale/translations/fr.js"></script>
<script>
const app = new Vue({
  el: '#app',
  data() {
    return {
      fr: vdp_translation_fr.js
    }
  },
  components: {
  	vuejsDatepicker
  },
    data() {
            return {
                disabledDates: {
                    to: new Date(2019, 10, 5), // Disable all dates up to specific date
                    from: new Date(2019, 11, 26), // Disable all dates after specific date
                    // days: [6, 0], // Disable Saturday's and Sunday's
                    // daysOfMonth: [29, 30, 31], // Disable 29th, 30th and 31st of each month
                    dates: [ // Disable an array of dates
                    new Date(2019, 10, 16),
                    new Date(2019, 9, 17),
                    new Date(2016, 9, 18)
                    ],
                    ranges: [{ // Disable dates in given ranges (exclusive).
                    from: new Date(2016, 11, 25),
                    to: new Date(2016, 11, 30)
                    }, {
                    from: new Date(2017, 1, 12),
                    to: new Date(2017, 2, 25)
                    }],
                    // a custom function that returns true if the date is disabled
                    // this can be used for wiring you own logic to disable a date if none
                    // of the above conditions serve your purpose
                    // this function should accept a date and return true if is disabled
                    // customPredictor: function(date) {
                    //     // disables the date if it is a multiple of 5
                    //     if(date.getDate() % 5 == 0){
                    //         return true
                    //     }
                    // }
                }
            }
    }

})
</script>



<script>
var state = {
  disabledDates: {
    to: new Date(2016, 0, 5), // Disable all dates up to specific date
    from: new Date(2016, 0, 26), // Disable all dates after specific date
    days: [6, 0], // Disable Saturday's and Sunday's
    daysOfMonth: [29, 30, 31], // Disable 29th, 30th and 31st of each month
    dates: [ // Disable an array of dates
      new Date(2016, 9, 16),
      new Date(2016, 9, 17),
      new Date(2016, 9, 18)
    ],
    ranges: [{ // Disable dates in given ranges (exclusive).
      from: new Date(2016, 11, 25),
      to: new Date(2016, 11, 30)
    }, {
      from: new Date(2017, 1, 12),
      to: new Date(2017, 2, 25)
    }],
    // a custom function that returns true if the date is disabled
    // this can be used for wiring you own logic to disable a date if none
    // of the above conditions serve your purpose
    // this function should accept a date and return true if is disabled
    customPredictor: function(date) {
      // disables the date if it is a multiple of 5
      if(date.getDate() % 5 == 0){
        return true
      }
    }
  }
}
</script>
<datepicker :disabled-dates="state.disabledDates"></datepicker>