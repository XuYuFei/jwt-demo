<template>
  <div class="nav">
    <ul>
      <router-link v-for="(item, index) in navs" :to="{name: item.name}" :key="index" tag="li" exact>{{item.title}}</router-link>
    </ul>
  </div>
</template>
<script>
export default {
  data () {
    return {
      navs: [
        { title: '首页', name: 'home' },
        { title: '分类', name: 'category' },
        { title: '登录', name: 'login' }
      ]
    }
  },
  created () {
  }
}
</script>
<style>
  .nav ul { position: fixed; bottom: 0; width: 100%; height: 50px; line-height: 50px; border-top: 1px solid #F3F3F3;}
  .nav li { float: left; display: inline; width: 33.33333%; text-align: center; cursor: pointer;}
  .nav li.active { color: red; }
</style>
