<template>
  <div>
    <p>登录</p>
    <br>
    <p>
      <button @click="login()">点击登录</button>
    </p>
  </div>
</template>
<script>
export default {
  methods: {
    // 登录
    login () {
      let token = localStorage.getItem('token')
      let data = { name: '北鱼', password: '123456' }
      let url = 'http://tp5/index/jwt/login'

      if (!token) {
        this.$axios.post(url, data).then((res) => {
          // 登录成功跳首页
          if (res.data.status === 'success') {
            this.$router.push({name: 'home'})
          }
        })
      } else {
        // 已登录跳首页
        this.$router.push({name: 'home'})
      }
    }
  }
}
</script>
