<template>
<q-page class="q-pa-xs bg-grey-3">
  <pre>{{movies}}</pre>
</q-page>
</template>
<script>
export  default {
  data() {
    return {
      movies: [],
      movie: {},
      loading: false,
    }
  },
  methods: {
    async getMovies() {
      this.loading = true
      const res = await this.$axios.get('/movies')
      this.movies = res.data
      this.loading = false
    }
  },
  created() {
    this.getMovies()
  }
}
</script>
