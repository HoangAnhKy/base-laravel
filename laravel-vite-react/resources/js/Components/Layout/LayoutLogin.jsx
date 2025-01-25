import Nav from "./Nav.jsx";
import {Outlet} from "react-router-dom";
import Alert from "./Alert.jsx";
import {useConfigGlobal} from "../Config/Config.jsx";

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
