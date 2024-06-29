<template>
<q-page class="q-pa-xs bg-grey-3">
  <div class="row">
    <div class="col-12">
      <q-table dense :loading="loading" :rows="movies">
        <template v-slot:top-right>
          <q-btn label="Crear" no-caps size="12px" color="green" icon="add_circle_outline" class="text-bold" @click="dialogMovieClick"/>
          <q-input v-model="filter" outlined dense placeholder="Buscar">
            <template v-slot:after>
              <q-icon name="search"/>
            </template>
          </q-input>
        </template>
      </q-table>
    </div>
  </div>
  <q-dialog v-model="dialogMovie">
    <q-card style="width: 700px; max-width: 90vw;">
      <q-card-section>
        <label class="text-subtitle2">Película</label>
        <q-input v-model="movie.title" outlined dense label="Título" placeholder="Título">
          <template v-slot:after>
            <q-btn dense icon="search" @click="searchMovie" :disable="!movie.title" label="Buscar" no-caps color="purple" :loading="loading"/>
          </template>
        </q-input>
        <label class="text-subtitle2">Datos</label>
        <q-input v-model="movie.json" outlined dense label="JSON" placeholder="JSON" type="textarea"/>
        <q-checkbox v-model="movie.proximo" label="Próximo"/>
        <q-card-actions align="right">
          <q-btn label="Cancelar" color="negative" @click="dialogMovie = false" :loading="loading"/>
          <q-btn label="Guardar" color="green" @click="dialogMovie = false" :loading="loading"/>
        </q-card-actions>
        <q-list bordered dense separator>
          <q-item v-for="item in resultMovies" :key="item.id">
            <q-item-section avatar>
              <q-avatar square v-if="item.poster_path" size="120px">
                <img :src="'https://image.tmdb.org/t/p/w500' + item.poster_path" alt="poster"/>
              </q-avatar>
              <q-avatar square v-else size="100px">
                <q-icon name="o_movie" size="50px"/>
              </q-avatar>
            </q-item-section>
            <q-item-section>
              <q-item-label>{{item.title}}</q-item-label>
              <q-item-label caption>{{item.release_date}}</q-item-label>
              <q-item-label caption>{{item.vote_average}}</q-item-label>
              <q-item-label caption>{{item.overview}}</q-item-label>
            </q-item-section>
            <q-item-section side>
              <q-btn dense icon="content_copy" color="green" @click="copiMovie(item)" label="Copiar" no-caps size="10px" :loading="loading"/>
            </q-item-section>
          </q-item>
        </q-list>
<!--        <pre>{{resultMovies}}</pre>-->
      </q-card-section>
    </q-card>
  </q-dialog>
  <pre>{{movies}}</pre>
</q-page>
</template>
<script>
export  default {
  data() {
    return {
      movies: [],
      movie: {
        title: '',
        json: '',
        proximo: false,
      },
      urlSearch:"https://api.themoviedb.org/3/search/movie?api_key=eccf4da78932269df065470af1b8c6d9&language=es-ES&query=",
      urlMovie:"https://api.themoviedb.org/3/movie/xxxxx?api_key=eccf4da78932269df065470af1b8c6d9&language=es-ES",
      loading: false,
      filter: '',
      dialogMovie: false,
      resultMovies: []
    }
  },
  methods: {
    copiMovie(item) {
      console.log(item)
      const url = this.urlMovie.replace('xxxxx', item.id)
      this.$axios.get(url)
        .then(res => {
          this.movie.json = JSON.stringify(res.data, null, 2)
        }).finally(() => {
        this.loading = false
        })
    },
    searchMovie() {
      this.loading = true
      this.resultMovies = []
      this.$axios.get(this.urlSearch + this.movie.title)
        .then(res => {
          this.resultMovies = res.data.results
        }).finally(() => {
        this.loading = false
        })
    },
    dialogMovieClick() {
      this.dialogMovie = true
      this.resultMovies = []
      this.movie = {
        title: '',
        json: '',
        proximo: false,
      }
    },
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
