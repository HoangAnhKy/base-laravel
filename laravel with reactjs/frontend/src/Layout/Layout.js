import Nav from "./Nav";
import SideBar from "./SideBar";
import Search from "./Search";
import Follow from "../User/Follow";
import {Outlet} from "react-router-dom";
import Alert from "./Alert";
import {useConfigGlobal} from "../Config/Config";

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