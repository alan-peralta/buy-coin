<script lang="ts">
import QuoteDataService from '@/services/QuoteDataService';
import { defineComponent } from 'vue';


export default defineComponent({
  name: 'list-quotes',
  data() {
    return {
      quotes: {}
    }
  },
  methods: {
    listQuotes() {
      QuoteDataService.getAll()
        .then((response) => {
          this.quotes = response.data['data'];
        })
        .catch((e: Error) => {
          console.log(e)
        });
    },
  },
  mounted() {
    this.listQuotes();
  },
});
</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/buy">Comprar</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-4">
    <div class="row">
      <div class="card">
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Moeda</th>
                <th scope="col">Valor</th>
              </tr>
            </thead>
            <tbody v-for="(quote, index) in quotes" :key="index">
              <tr>
                <th scope="row">{{ quote.from }} - {{ quote.name }}</th>
                <td>{{ quote.value_formatted }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
