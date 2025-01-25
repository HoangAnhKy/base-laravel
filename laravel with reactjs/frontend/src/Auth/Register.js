import {Link, useNavigate} from "react-router-dom";
import {useState} from "react";
import useAxios from "../axios";
import {useConfigGlobal} from "../Config/Config";

const Register = () => {

    const [name, setName] = useState("hin");
    const [email, setEmail] = useState("hin@gmail.com");
    const [password, setPassword] = useState("123456");

    const axios = useAxios();
    const globalConfig = useConfigGlobal();
    const navigate = useNavigate();

    const handleRegister = () => {
        const data = {
            name,
            email,
            password
        }

        axios.post("api/register", data)
            .then(function (resp) {
                globalConfig.notification(resp?.data?.message);
                navigate("/login");
            })
            .catch(function (resp) {
                globalConfig.notification(resp.response?.data?.message, "danger");
            })
    }

    return <>
        <div className="row justify-content-center">
            <div className="col-12 col-sm-8 col-md-6">
                <form className="form mt-5" action="" method="post">
                    <h3 className="text-center text-dark">Register</h3>
                    <div className="form-group">
                        <label htmlFor="name" className="text-dark">Name:</label><br/>
                        <input type="text" name="name" id="name" value={name} onChange={(e) => setName(e.target.value)} className="form-control"/>
                    </div>
                    <div className="form-group mt-3">
                        <label htmlFor="email" className="text-dark">Email:</label><br/>
                        <input type="email" name="email" id="email" value={email} onChange={(e) => setEmail(e.target.value)} className="form-control"/>
                    </div>
                    <div className="form-group mt-3">
                        <label htmlFor="password" className="text-dark">Password:</label><br/>
                        <input type="password" name="password" id="password" value={password} onChange={(e) => setPassword(e.target.value)} className="form-control"/>
                    </div>
                    <div className="form-group mt-3">
                        <input type="button" name="submit" onClick={handleRegister} className="btn btn-dark btn-md" value="submit"/>
                    </div>
                    <div className="text-right mt-2">
                    <Link to="/login" className="text-dark"> Login here </Link>
                    </div>
                </form>
            </div>
        </div>
    </>
}

export default Register;