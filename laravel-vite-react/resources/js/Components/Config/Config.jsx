import {createContext, memo, useContext, useEffect, useState} from "react";
import useAxios from "../../axios";
import Cookies from "js-cookies/src/cookies";

export const ConfigContext = createContext(null);

const Config = ({children}) => {
    const [alert, setAlert] = useState({message: "", type: "success"});
    const [userLogin, setUserLogin] = useState(null);
    const [keySearch, setKeySearch] = useState("");
    const [search, setSearch] = useState(false);
    const [loading, setLoading] = useState(false);

    const axios = useAxios();

    useEffect(() => {
        if (Cookies.getItem("sys_token")) {
            axios.get("/api/user")
                .then(function (resp) {
                    setUserLogin(resp?.data?.user)
                })
        }
    }, []);
    const notification = (message = "", type = "success") => setAlert({message, type});
    const handleUserLogin = (user = []) => setUserLogin(user)
    const handleKeySearch = (search = []) => setKeySearch(search)
    const handleBtnSearch = () => setSearch(!search)
    const handleLoading = () => setLoading((val) => !val)
    const handleLogout = () => {

        axios.post("api/logout")
            .then(function (resp) {
                notification(resp?.data?.message)
                setUserLogin(null)
            })
            .catch(function (resp) {
                notification(resp?.response?.data?.message, "danger")
            })
    }

    return (
        <ConfigContext.Provider value={{
            loading, handleLoading,
            keySearch, handleKeySearch,
            search, handleBtnSearch,
            alert, notification,
            userLogin, handleUserLogin, handleLogout
        }}>
            {children}
        </ConfigContext.Provider>
    );
};

export default memo(Config);

export const useConfigGlobal = () => useContext(ConfigContext);
