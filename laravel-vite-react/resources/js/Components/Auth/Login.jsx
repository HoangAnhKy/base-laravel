import {Link, useNavigate} from "react-router-dom";
import {useState} from "react";
import useAxios from "../../axios";
import {useConfigGlobal} from "../Config/Config.jsx";

const Login = () => {

    const [email, setEmail] = useState("hin@gmail.com");
    const [password, setPassword] = useState("123456");

    const axios = useAxios();
    const globalConfig = useConfigGlobal();
    const navigate = useNavigate();

    const handleLogin = () => {
        const data = {
            email,
            password
        }
        axios.post("api/login", data)
            .then(function (resp) {
                globalConfig.notification(resp?.data?.message);
                globalConfig.handleUserLogin(resp?.data?.user ?? []);
                navigate("/");
            })
            .catch(function (resp) {
                globalConfig.notification(resp.response?.data?.message, "danger");
            })
    }

    return <>
        <div className="row justify-content-center">
            <div className="col-12 col-sm-8 col-md-6">
                <form className="form mt-5">
                    <h3 className="text-center text-dark">Login</h3>
                    <div className="form-group">
                        <label htmlFor="email" className="text-dark">Email:</label><br/>
                        <input type="email" name="email" id="email" className="form-control" value={email}
                               onChange={(e) => setEmail(e.target.value)}/>
                    </div>
                    <div className="form-group mt-3">
                        <label htmlFor="password" className="text-dark">Password:</label><br/>
                        <input type="password" name="password" id="password" className="form-control" value={password}
                               onChange={(e) => setPassword(e.target.value)}/>
                    </div>
                    <div className="form-group">
                        <label htmlFor="remember-me" className="text-dark"></label><br/>
                        <input type="button" name="submit" className="btn btn-dark btn-md" value="submit" onClick={handleLogin}/>
                    </div>
                    <div className="text-right mt-2">
                        <Link to="/register" className="text-dark">Register here</Link>
                    </div>
                </form>
            </div>
        </div>
    </>
}

export default Login;
