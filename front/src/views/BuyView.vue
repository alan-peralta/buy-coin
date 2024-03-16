<script lang="ts">
import QuoteDataService from '@/services/QuoteDataService';
import {defineComponent} from 'vue';
import axios from "axios";
import axiosIns from "@/plugins/axios";
import getCookie from "@/plugins/csrf";

// const getToken = async () => {
//   await axios.get('http://localhost:8000/sanctum/csrf-cookie');
// };

export default defineComponent({
  name: 'list-quotes',
  data() {
    return {
      coins: {},
      order: {
        currency: "",
        amount: ""
      }
    }
  },
  methods: {
    getCoins() {
      QuoteDataService.getCoins()
          .then((response) => {
            this.coins = response.data;
          })
          .catch((e: Error) => {
            console.log(e)
          });
    },
    async prepareOrder() {
      await getCookie();
      axiosIns.post('v1/prepare-order', this.order)
          .then((response) => {
            console.log(response.data);
          })
          .catch((e: Error) => {
            console.log(e)
          });
    }
  },
  mounted() {
    this.getCoins();
  },
});
</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="Toggle navigation">
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
          <form>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Moeda</label>
              <select class="form-select" v-model="order.currency">
                <option selected>Selecione</option>
                <option v-for="(coin, index) in coins" :value="index">{{ coin }}</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="amount" class="form-label">Valor (R$)</label>
              <input type="tel" class="form-control" id="amount" v-model="order.amount">
            </div>
            <button type="button" class="btn btn-primary" v-on:click="prepareOrder">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
