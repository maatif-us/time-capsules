<template>
   <el-input v-model="searchQuery" @input="handleSearchChange"  placeholder="Search..." clearable></el-input>
  </template>
  
  <script>
  export default {
   name: 'InputComponent',
   props: {
      searchQuery: String,
   },
   methods: {
      handleSearchChange(value) {
        this.$emit('update:searchQuery', value);
      },
   },
  };
  </script>