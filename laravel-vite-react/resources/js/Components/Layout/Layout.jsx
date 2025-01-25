import Nav from "./Nav.jsx";
import SideBar from "./SideBar.jsx";
import Search from "./Search.jsx";
import Follow from "../User/Follow.jsx";
import {Outlet} from "react-router-dom";
import Alert from "./Alert.jsx";
import {useConfigGlobal} from "../Config/Config.jsx";

const LayoutDefault = () => {
    const globalConfig = useConfigGlobal();
    return <>
        <Nav/>
        <div className="container py-4">
            <div className="row">
                <div className="col-3">
                    <SideBar/>
                </div>
                <div className="col-6">
                    {globalConfig.alert.message !== "" && <Alert alert={globalConfig.alert}/>}
                    <Outlet/>
                </div>
                <div className="col-3">
                    <Search/>
                    <Follow/>
                </div>
            </div>
        </div>
    </>
}

export default LayoutDefault;
