<template>
  <router-view></router-view>
</template>

<script>

export default {
  name: 'App'
}
</script>

<style lang="scss">
@import "./fonts.scss";
@import '~bootstrap/dist/css/bootstrap.css';
#app {
  font-family: 'Quicksand-Regular';
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  background-color: #ECEFF1;
  width: 100vw;
  height: 100vh;
}
</style>
