import axiosIns from "@/plugins/axios";
import Cookie from "js-cookie"

const getCookie = () => {
    const token = Cookie.get("XSRF-TOKEN");
    if (token) {
        return new Promise(resolve => {
            resolve(token);
        })
    }

    return axiosIns.get('http://localhost:8000/sanctum/csrf-cookie')
}

export default getCookie