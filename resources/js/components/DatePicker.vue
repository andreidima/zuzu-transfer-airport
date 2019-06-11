<script>
import DatePicker from 'vue2-datepicker';
import moment from 'moment';
 
export default {
  components: { DatePicker },
  props: ['dataVeche', 'numeCampDb', 'tip', 'latime'],
  data() {
    return {
      time1: '',
      time2: '',
      time3: '',
      dataNoua: '',
      format: '',
      // custom lang
      lang: {
        days: ['Dum', 'Lun', 'Mar', 'Mie', 'Joi', 'Vin', 'Sâm'],
        months: ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun', 'Iul', 'Aug', 'Sep', 'Oct', 'Noi', 'Dec'],
        pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
        placeholder: {
          date: 'Selectează Data',
          dateRange: 'Select Date Range'
        }
      },
      // custom range shortcuts
      shortcuts: [
        {
          text: 'Today',
          onClick: () => {
            this.time3 = [ new Date(), new Date() ]
          }
        }
      ],
      timePickerOptions:{
        start: '00:00',
        step: '00:30',
        end: '23:30'
      }
    }
  },
    created() {
        if (this.dataVeche == "") {
            this.time2 = new Date()
            this.dataNoua = moment(this.time2, 'DD.MM.YYYY, HH:mm'). format('YYYY-MM-DD')
        }
        else {
          this.time2 = this.dataVeche,
          this.dataNoua = this.dataVeche
        }

        if (this.tip == "date"){
          this.format = "DD.MM.YYYY"
        }
        else {
          this.format = "DD.MM.YYYY, HH:mm"
        }
    },
    updated() {
      if (this.time2 instanceof Date) {
        this.dataNoua = moment(this.time2, 'DD.MM.YYYY, HH:mm'). format('YYYY-MM-DD')
      }
      else {
        this.dataNoua = ''
      }

      if (this.tip == "date"){
        this.format = "DD.MM.YYYY"
      }
      else {
        this.format = "DD.MM.YYYY, HH:mm"
      }
    }


}
</script> 
 
<template>
  <div>
    <!-- <p>dataVeche = {{ dataVeche }}</p>
    <p>dataNoua = {{ dataNoua }}</p>
    <p>time2 = {{ time2 }}</p> -->
    <input type="text" :name=numeCampDb v-model="dataNoua" v-show="false">
    <!-- <date-picker v-model="time1" :first-day-of-week="1"></date-picker> -->
    <date-picker 
      v-model="time2"
      :type=tip
      :format="format"
      :width="latime"
      :height="10"
      :clearable=true
      :first-day-of-week="1"
      :lang="lang"
      :time-picker-options="timePickerOptions">
    </date-picker>
    <!-- <date-picker v-model="time3" range :shortcuts="shortcuts"></date-picker> -->
    <!-- <date-picker v-model="value" :lang="lang"></date-picker> -->
  </div>
</template>