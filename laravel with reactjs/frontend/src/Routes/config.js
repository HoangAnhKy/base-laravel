import {Route, Routes} from "react-router-dom";
import Layout from "../Layout/Layout";
import Index from "../IDeas/Index";
import Profile from "../User/Profile";
import LayoutLogin from "../Layout/LayoutLogin";
import Login from "../Auth/Login";
import Register from "../Auth/Register";
import Loading from "../Layout/Loading";
import {useConfigGlobal} from "../Config/Config";

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