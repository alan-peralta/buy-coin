import http from "@/http-common";

/* eslint-disable */
class QuoteDataService {
  getAll(): Promise<any> {
    return http.get("/v1/quotes");
  }

  getCoins(): Promise<any> {
    return http.get('/v1/coins');
  }

//   create(data: any): Promise<any> {
//     return http.post("/tutorials", data);
//   }

//   update(id: any, data: any): Promise<any> {
//     return http.put(`/tutorials/${id}`, data);
//   }

//   delete(id: any): Promise<any> {
//     return http.delete(`/tutorials/${id}`);
//   }

//   deleteAll(): Promise<any> {
//     return http.delete(`/tutorials`);
//   }

//   findByTitle(title: string): Promise<any> {
//     return http.get(`/tutorials?title=${title}`);
//   }
}

export default new QuoteDataService();