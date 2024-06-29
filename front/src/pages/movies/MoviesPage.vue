<template>
<q-page class="q-pa-xs bg-grey-3">
  <div class="row">
    <div class="col-12">
      <q-table dense :loading="loading" :rows="movies" :filter="filter" :rows-per-page-options="[0]" :columns="columns">
        <template v-slot:top-right>
          <q-btn label="Crear" no-caps size="12px" color="green" icon="add_circle_outline" class="text-bold" @click="dialogMovieClick"/>
          <q-input v-model="filter" outlined dense placeholder="Buscar">
            <template v-slot:after>
              <q-icon name="search"/>
            </template>
          </q-input>
        </template>
        <template v-slot:body-cell-proximo="props">
          <q-td :props="props">
            <q-btn dense :color="props.row.proximo ? 'green' : 'red'" text-color="white" @click="clickProximo(props.row)" no-caps :loading="loading">
              {{props.row.proximo ? 'Si' : 'No'}}
            </q-btn>
          </q-td>
        </template>
        <template v-slot:body-cell-activo="props">
          <q-td :props="props">
            <q-btn dense :color="props.row.activo ? 'green' : 'red'" text-color="white" @click="clickActivo(props.row)" no-caps :loading="loading">
              {{props.row.activo ? 'Si' : 'No'}}
            </q-btn>
          </q-td>
        </template>
      </q-table>
    </div>
  </div>
  <q-dialog v-model="dialogMovie">
    <q-card style="width: 700px; max-width: 90vw;">
      <q-card-section class="q-pb-none">
          <div class="row items-center">
            <div class="col text-bold">{{movie.id ? 'Editar' : 'Crear'}} Película</div>
            <div class="col-auto">
              <q-btn dense icon="close" flat @click="dialogMovie = false" :loading="loading"/>
            </div>
          </div>
      </q-card-section>
      <q-card-section>
        <q-form @submit="movieSubmit">
        <label class="text-subtitle2">Película</label>
        <q-input v-model="movie.title" outlined dense label="Título" placeholder="Título">
          <template v-slot:after>
            <q-btn dense icon="search" @click="searchMovie" :disable="!movie.title" label="Buscar" no-caps color="purple" :loading="loading"/>
          </template>
        </q-input>
        <label class="text-subtitle2">Datos</label>
        <q-input v-model="movie.json" outlined dense label="JSON" placeholder="JSON" type="textarea"/>
        <q-checkbox v-model="movie.proximo" label="Próximo"/>
        <q-checkbox v-model="movie.activo" label="Activo"/>
        <q-card-actions align="right">
          <q-btn label="Cancelar" color="negative" @click="dialogMovie = false" :loading="loading"/>
          <q-btn label="Guardar" color="green" type="submit"/>
        </q-card-actions>
        </q-form>
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
      columns: [
        {name: 'actions', label: 'Acciones', align: 'center', field: 'actions'},
        {name: 'id', label: 'ID', align: 'center', field: 'id'},
        {name: 'title', label: 'Título', align: 'left', field: 'title'},
        {name: 'proximo', label: 'Próximo', align: 'center', field: 'proximo'},
        {name: 'activo', label: 'Activo', align: 'center', field: 'activo'},
      ],
      movie: {
        title: '',
        json: '',
        proximo: false,
        activo: true,
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
    clickActivo(movie) {
      movie.activo = !movie.activo
      this.movie = movie
      this.movieSubmit()
    },
    clickProximo(movie) {
      movie.proximo = !movie.proximo
      this.movie = movie
      this.movieSubmit()
    },
    movieSubmit() {
      this.loading = true
      if (this.movie.id) {
        this.$axios.put('/movies/' + this.movie.id, this.movie)
          .then(() => {
            this.getMovies()
            this.dialogMovie = false
          }).finally(() => {
          this.loading = false
          })
      } else {
        this.$axios.post('/movies', this.movie)
          .then(() => {
            this.getMovies()
            this.dialogMovie = false
          }).finally(() => {
          this.loading = false
          })
      }
    },
    copiMovie(item) {
      // console.log(item)
      this.movie.title = item.title
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
        activo: true,
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
