<template>
  <div><br/><br/>
    <p>category</p><br/><br/>
    <p v-if="create_time">token创建时间：{{ create_time }}</p>
    <p v-if="status">status：{{ status }} - {{ msg }}</p><br/><br/>
    <ul>
      <li v-for="(item, index) in list" :key="index" >{{item.title}} - {{item.desc}}</li>
    </ul>
  </div>
</template>
<script>
export default {
  data () {
    return {
      list: [],
      create_time: '',
      status: '',
      msg: ''
    }
  },
  created () {
    this.getList()
  },
  methods: {
    getList () {
      let url = 'http://tp5/index/jwt/getList'
      this.$axios.post(url).then((res) => {
        this.list = res.data.list
        this.create_time = res.data.create_time
        this.status = res.data.status
        this.msg = res.data.msg

        // 如果失败，则清除token
        if (res.data.status === 'fail') {
          localStorage.removeItem('token')
        }
      })
    }
  }
}
</script>
