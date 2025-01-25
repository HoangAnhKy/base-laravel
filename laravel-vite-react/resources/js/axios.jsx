import axios from "axios";
import Cookies from "js-cookies/src/cookies";

const useAxios = () => {
    const token = Cookies.getItem('sys_token');
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

    const http = axios.create({
        baseURL: import.meta.env.BASE_URL,
        withCredentials: true,
    });

    const post = (url, data = {}, config = {}) => {
        return http.post(url, data, config);
    };
    const get = (url, params = {}) => {
        return http.get(url, {params});
    };
    return {get, post};
}

export default useAxios
