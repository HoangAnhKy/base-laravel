import Nav from "./Nav";
import {Outlet} from "react-router-dom";
import Alert from "./Alert";
import {useConfigGlobal} from "../Config/Config";

const LayoutDefault = () => {
    const globalConfig = useConfigGlobal();
    return <>
        <Nav/>
        <div className="container py-4">
            {globalConfig.alert.message !== "" && <Alert alert={globalConfig.alert}/>}
            <Outlet/>
        </div>
    </>
}

export default LayoutDefault;