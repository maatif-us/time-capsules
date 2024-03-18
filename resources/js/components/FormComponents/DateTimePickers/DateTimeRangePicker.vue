<template>
    <el-date-picker
       v-model="dateTimeRange"
       type="datetimerange"
       range-separator="to"
       start-placeholder="Start Date"
       end-placeholder="End Date"
       @change="handleDateTimeChange"
    ></el-date-picker>
</template>
   
<script>
   export default {
      name: 'dateTimeRangePicker',
    props: {
       dateTimeRange: Array,
    },
    methods: {
       handleDateTimeChange(value) {
         this.$emit('update:dateTimeRange', value);
       },
    },
   };
</script>
   