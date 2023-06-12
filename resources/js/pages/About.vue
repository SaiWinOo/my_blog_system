<template>
  <div>
    About Page
  </div>
</template>

<script setup>
import { onMounted } from 'vue';



onMounted(() => {
  console.log('hello')
  window.axios.get('/users')

    .then(res => console.log(res.data));
})
</script>
