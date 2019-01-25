<template>
  <div class="home">
    <p>首页</p>
    {{ isLogin ? '已登录' : '未登录'}}
  </div>
</template>
<script>
export default {
  computed: {
    isLogin () {
      let token = window.localStorage.getItem('token')
      if (token && token !== 'undefined') {
        return true
      }
      return false
    }
  }
}
</script>
<style>
  .home { padding-top: 100px; line-height: 50px; }
</style>
