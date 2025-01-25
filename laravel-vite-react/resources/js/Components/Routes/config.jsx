import {Route, Routes} from "react-router-dom";
import Layout from "../Layout/Layout.jsx";
import Index from "../IDeas/Index.jsx";
import Profile from "../User/Profile.jsx";
import LayoutLogin from "../Layout/LayoutLogin.jsx";
import Login from "../Auth/Login.jsx";
import Register from "../Auth/Register.jsx";
import Loading from "../Layout/Loading.jsx";
import {useConfigGlobal} from "../Config/Config.jsx";

const Web = () => {
    const global = useConfigGlobal()

    return <>
        {global.loading && <Loading />}
        <Routes>
            <Route path="/" element={<Layout />}>
                <Route index element={<Index />}/>
                <Route path="/profile" element={<Profile />}/>
            </Route>
            <Route path="/" element={<LayoutLogin />}>
                <Route path="/login" index element={<Login />}/>
                <Route path="/register" element={<Register />}/>
            </Route>
        </Routes>
    </>
}
export default Web;
